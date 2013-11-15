<?php
/*
 * Original migration script to new plugin project/plugin release structure
 */

require 'engine/start.php';
elgg_set_ignore_access(TRUE);
set_time_limit(0);

global $CONFIG, $DB_QUERY_CACHE, $DB_PROFILE, $ENTITY_CACHE;

$id = get_subtype_id('object', 'plugins');

// get all plugin guids that don't have a next version.
// these are the latest versions of each plugin available in the system.
$q = "SELECT guid FROM elggentities
	WHERE subtype = $id
	AND guid NOT IN
		(SELECT guid_one FROM elggentity_relationships WHERE relationship = 'next_version')
	ORDER BY guid
	";
$data = get_data($q);

// convert old style to new style
// old => new
$plugin_convert_array = array(
	'description' => 'release_notes',
);

$plugin_defaults_array = array(
	'title' => '',
	'description' => '',
);

$project_defaults_array = array(
	//'plugincat' => 'uncategorized',
	'homepage' => '',
	'repo' => '',
	'digg' => 0,
	'download_num' => 0
);

$project_convert_array = array(
	'owner_guid' => 'owner_guid',
	'container_guid' => 'container_guid',
	'access_id' => 'access_id',
	'title' => 'title',
	//'description' => 'description',
	'intro' => 'summary',
	'tags' => 'tags',
	'license' => 'license',
	'simpletype' => 'plugintype'
);

// update the subtypes to match the new one
$q = "UPDATE elggentity_subtypes SET subtype='plugin_file' WHERE type = 'object' AND subtype='plugins'";
mysql_query($q);

// These are already FilePluginFile
// So we just need to create a project to contain them.
// After creating a project, while through each prev_version
// and change the container to the project and add the relationship is_plugin (probably not required, tbh)
foreach ($data as $plugin_guid) {
	$DB_QUERY_CACHE = $DB_PROFILE = $ENTITY_CACHE = array();

	$plugin = get_entity($plugin_guid->guid);

	// Create a new project container.
	$project = new ElggObject();
	$project->subtype = 'plugin_project';
	$project->owner_guid = $plugin->owner_guid;
	$project->save();
	var_dump("Project: {$project->getGUID()}\n");

	// set the project's creation and update time to the earliest plugin file's
	$q = "UPDATE elggentities SET time_updated={$plugin->time_updated} WHERE guid={$project->getGUID()}";
	var_dump($q);
	mysql_query($q);
	var_dump(mysql_error());


	$cat = NULL;
	foreach ($CONFIG->plugincats as $short=>$long) {
		if (TRUE === strpos(strtolower($plugin->title), $short)) {
			$cat = $short;
			break;
		}
	}

	$project->plugincat = ($cat) ? $cat : 'uncategorized';

	foreach ($project_defaults_array as $key=>$value) {
		$project->$key = $value;
	}

	foreach ($project_convert_array as $old=>$new) {
		if ($plugin->$old) {
			//var_dump("Setting $old = '{$plugin->$old}' to $new\n");
			$project->$new = $plugin->$old;
		}
	}

	// special case for description.
	// It's too confusing to have the description duplicated in release notes,
	// so tag the description here same as the title with a note to update
	$project->description = $plugin->title . "<br /><br />\n\n(Edit your project's description!)";

	$project->save();

	// fix up the plugin
	$plugin->container_guid = $project->getGUID();
	add_entity_relationship($project->getGUID(), 'is_plugin', $plugin->getGUID());
	foreach ($plugin_convert_array as $old=>$new) {
		var_dump("Setting $old ({$plugin->$old}) to $new\n");
		if ($plugin->$old) {
			$plugin->$new = $plugin->$old;
		}
	}

	foreach ($plugin_defaults_array as $key=>$value) {
		$plugin->$key = $value;
	}


	$plugin->save();

	// copy download annotations to the project
	$q = "SELECT * FROM elggannotations WHERE entity_guid = {$plugin->getGUID()}";
	$r = mysql_query($q);
	while ($row = mysql_fetch_assoc($r)) {
		$q = "INSERT INTO elggannotations
			(id, entity_guid, name_id, value_id, value_type, owner_guid, access_id, time_created, enabled) VALUES
			('', '{$project->getGUID()}', '{$row['name_id']}', '{$row['value_id']}', '{$row['value_type']}', '{$row['owner_guid']}',
				'{$row['access_id']}', '{$row['time_created']}', '{$row['enabled']}')";
		mysql_query($q);
	}

	$tmp = elgg_get_entities_from_relationship(array('relationship' => 'prev_version', 'relationship_guid'=>$plugin_guid->guid));
	if (is_array($tmp)) {
		$prev_version_guid = $tmp[0]->guid;
	} else {
		$prev_version_guid = FALSE;
	}


	while ($prev_version_guid) {
		if (!$plugin = get_entity($prev_version_guid)) {
			continue;
		}
		$plugin->container_guid = $project->getGUID();
		$plugin->save();
		add_entity_relationship($project->getGUID(), 'is_plugin', $plugin->getGUID());

		foreach ($plugin_convert_array as $old=>$new) {
			if ($plugin->$old) {
				$plugin->$new = $plugin->$old;
			}
		}

		foreach ($plugin_defaults_array as $key=>$value) {
			$plugin->$key = $value;
		}


		// copy download annotations to the project
		$q = "SELECT * FROM elggannotations WHERE entity_guid = {$plugin->getGUID()}";
		$r = mysql_query($q);
		while ($row = mysql_fetch_assoc($r)) {
			$q = "INSERT INTO elggannotations
				(id, entity_guid, name_id, value_id, value_type, owner_guid, access_id, time_created, enabled) VALUES
				('', '{$project->getGUID()}', '{$row['name_id']}', '{$row['value_id']}', '{$row['value_type']}', '{$row['owner_guid']}',
					'{$row['access_id']}', '{$row['time_created']}', '{$row['enabled']}')";
			var_dump($q);
			mysql_query($q);
			var_dump(mysql_error());
		}


		var_dump("Plugin: {$plugin->getGUID()}\n");

		if ($tmp = elgg_get_entities_from_relationship(array('relationship' => 'prev_version', 'relationship_guid'=>$prev_version_guid))) {
			$prev_version_guid = $tmp[0]->guid;
		} else {
			$prev_version_guid = FALSE;
		}
	}

	// set the project's creation and update time to the earliest plugin file's
	$q = "UPDATE elggentities SET time_created={$plugin->time_created} WHERE guid={$project->getGUID()}";
	var_dump($q);
	mysql_query($q);
	var_dump(mysql_error());
}

// set site md for download count
$options = array(
	'type' => 'object',
	'subtype' => 'plugins',
	'annotation_name' => 'download',
	'count' => true,
);
$count = elgg_get_annotations($options);

$CONFIG->site->plugins_download_count = $count;

echo "Ding!";
