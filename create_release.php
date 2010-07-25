<?php
/**
 * Release a new version of a plugin
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

$project_guid = (int) get_input('project_guid');
$project = get_entity($project_guid);
if (!$project || !$project->canEdit()) {
	register_error('Unknown project or insufficient access to specified project.');
	forward();
}

set_page_owner($project->owner_guid);

$area1 = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:new:release');

$area2 = elgg_view_title($title);
$area2 .= elgg_view("plugins/forms/create_release", array('project' => $project));

$body = elgg_view_layout('sidebar_boxes', $area1, $area2);
page_draw($title, $body);
