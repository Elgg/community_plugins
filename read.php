<?php
/**
 * View a plugin project
 */

// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Get the specified plugin project
$project_guid = (int) get_input('guid');
$release_guid = (int) get_input('release');

if ($release_guid) {
	$release = get_entity($release_guid);
	$project_guid = $release->container_guid;
}

// If we can get out the plugin ...
if ($project = get_entity($project_guid)) {

	// redirect to the project if this is a file
	if ($project->getSubtype() == 'plugin_file') {
		if ($real_project = get_entity($project->container_guid)) {
			$url = $project->getURL();
			forward($url);
		} else {
			register_error('Could not find plugin!');
			forward();
		}
	}

	// Set the page owner
	set_page_owner($project->getOwner());
	$page_owner = get_entity($project->getOwner());

	//grab the entity and sidebar views
	$area2 = elgg_view_entity($project, true);
	$area1 = elgg_view('plugins/plugin_sidebar', array('entity' => $project));

	// Display through the correct canvas area
	$body = elgg_view_layout("sidebar_boxes", $area1, $area2);

// If we're not allowed to see the plugin
} else {
	// Display the 'plugin not found' page instead
	$body = elgg_view("plugins/notfound");
	$title = elgg_echo("plugins:notfound");
}

// Display page
page_draw($title,$body);
