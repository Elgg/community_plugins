<?php
/**
 * Reset the download counter and then sum up downloads on all projects
 */

global $CONFIG;
global $DB_QUERY_CACHE, $DB_PROFILE, $ENTITY_CACHE;

$site = $CONFIG->site;

// make sure the plugins_download_count metadata is deleted
$md = get_metadata_byname($site->guid, 'plugins_download_count');
if ($md) {
	if (!is_array($md)) {
		foreach ($md as $metadata) {
			delete_metadata($metadata->id);
		}
	} else {
		delete_metadata($md->id);
	}
}

$total_downloads = 0;

// loop over all plugin projects
$step = 100;
$options = array(
	'type' => 'object',
	'subtype' => 'plugin_project',
	'count' => TRUE,
);
$num_projects = elgg_get_entities_from_metadata($options);
$start_offset = $num_projects - $step;
if ($start_offset < 0) {
	$start_offset = 0;
}
$options = array(
	'type' => 'object',
	'subtype' => 'plugin_project',
	'offset' => $start_offset,
	'limit' => $step,
);
while ($projects = elgg_get_entities_from_metadata($options)) {
	$DB_QUERY_CACHE = $DB_PROFILE = $ENTITY_CACHE = array();

	foreach ($projects as $project) {
		$total_downloads += $project->getDownloadCount();
	}

	$options['offset'] = $options['offset'] - $step;
	// special catch for when we go negative in offset
	if ($options['offset'] < 0) {
		if ($options['offset'] == (-1 * $step)) {
			// okay, we got everything so quit
			break;
		} else {
			$options['offset'] = 0;
		}
	}
}

$site->plugins_download_count = $total_downloads;

system_message("Plugin downloads set to $site->plugins_download_count");
forward(REFERER);
