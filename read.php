<?php
/**
 * View a plugin project or release
 */

// leave in in case it is called directly
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// for backward compatibility if called directly
set_context('plugins');

// Get the specified plugin project
$project_guid = (int) get_input('guid');
$release_guid = (int) get_input('release');

if ($release_guid) {
	$release = get_entity($release_guid);
	if ($release) {
		$project_guid = $release->container_guid;
	}
}

$project = get_entity($project_guid);
if (!$project) {
	$body = elgg_view("plugins/notfound");
	$title = elgg_echo("plugins:notfound");
	page_draw($title, $body);
	exit;
}

$title = $project->title;

// this is probably here for backward compatibility - guid was a release
if ($project->getSubtype() == 'plugin_release') {
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

// grab the entity and sidebar views
$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));
$content = elgg_view_entity($project, TRUE);

$body = elgg_view_layout("sidebar_boxes", $sidebar, $content);

page_draw($title, $body);
