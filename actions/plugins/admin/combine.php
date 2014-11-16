<?php
/**
 * Action for combining two plugin projects
 */

$old_guid = (int)get_input('old_guid');
$new_guid = (int)get_input('new_guid');

$old_project = get_entity($old_guid);
$new_project = get_entity($new_guid);

if (!($old_project instanceof PluginProject) ||
	!($new_project instanceof PluginProject)) {
	register_error(elgg_echo('plugins:action:combine:invalid_guids'));
	forward(REFERER);
}

$old_name = $old_project->title;

// delete old screenshots to clear up filesystem
// note this needs to happen before $new_project->moveFilesOnSystem()
$old_screenshots = $old_project->getScreenshots();
if ($old_screenshots) {
	foreach ($old_screenshots as $s) {
		$s->delete();
	}
}

// move releases for the old project to the new project
$params = array(
	'types' => 'object',
	'subtypes' => 'plugin_release',
	'container_guids' => $old_project->guid,
	'limit' => 0,
);
$releases = elgg_get_entities($params);

$new_releases = elgg_get_entities(array_merge($params, array('container_guids' => $new_project->guid, 'limit' => 1)));
$new_releases_name = '';
if ($new_releases) {
	$info = pathinfo($new_releases[0]->originalfilename);
	$new_releases_name =  $info['filename'];
}

foreach ($releases as $release) {
	// append suffix on duplicate release versions
	$dupe = $new_project->getReleaseFromVersion($release->version);
	if ($dupe) {
		$release->version = $release->version . '-old';
	}
	
	$new_project->moveFilesOnSystem($release, $new_project->guid);
	$release->owner_guid = $new_project->guid;
	$release->container_guid = $new_project->guid;
	$release->save();
	
	if ($new_releases_name) {
		$prefix = "plugins/";
		// update file names on the filestore
		$oldname = $release->getFilenameOnFilestore();
		$info = pathinfo($oldname);
		
		$new_file_name = $new_releases_name . '.' . $info['extension'];
		$release->setFilename($prefix . strtolower($release->time_created . $new_file_name));
		$release->originalfilename = $new_file_name;
		$newname = $release->getFilenameOnFilestore();
		rename($oldname, $newname);
	}
}

// move download count to new project
$annotation_name = get_metastring_id('download', TRUE);
if ($annotation_name) {
	$dbprefix = elgg_get_config('dbprefix');
	$query = "UPDATE {$dbprefix}annotations
		SET entity_guid=$new_project->guid
		WHERE entity_guid=$old_project->guid AND name_id=$annotation_name";
	update_data($query);
}

$old_project->delete();

system_message(elgg_echo('plugins:action:combine:success', array($old_guid, $new_guid)));
forward(REFERER);
