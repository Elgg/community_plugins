<?php
/**
 * Release a new version of a plugin
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

$project_guid = (int) get_input('project_guid');
if (($project = get_entity($project_guid)) && $project->canEdit()) {
	$area1 = elgg_view('plugins/plugin_sidebar', array('entity' => $project));

	$area2 = elgg_view_title($title = elgg_echo('plugins:update'));
	$area2 .= elgg_view("plugins/update",array('project' => $project));

	$body = elgg_view_layout('sidebar_boxes', $area1, $area2);
	page_draw(elgg_echo("plugins:upload"), $body);
} else {
	register_error('Unknown project or insufficient access to specified project.');
	forward();
}