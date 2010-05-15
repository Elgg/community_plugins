<?php
/**
 * Edit plugin project
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

$project_guid = (int) get_input('project_guid');
$project = get_entity($project_guid);

if (!$project || !$project->canEdit()) {
	register_error('Unknown project or insufficient access.');
	forward();
}

$area1 = elgg_view('plugins/plugin_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:edit:project');

$area2 = elgg_view_title($title);
$area2 .= elgg_view("plugins/forms/edit_project", array('project' => $project));

$body = elgg_view_layout('sidebar_boxes', $area1, $area2);
page_draw($title, $body);
