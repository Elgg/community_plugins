<?php
/**
 * Release a new version of a plugin
 */

gatekeeper();

$project_guid = (int) get_input('project_guid');
$project = get_entity($project_guid);
if (!$project || !$project->canEdit()) {
	register_error('Unknown project or insufficient access to specified project.');
	forward();
}

set_page_owner($project->owner_guid);

$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:new:release');

$content = elgg_view_title($title);
$content .= elgg_view("plugins/forms/create_release", array('project' => $project));

$body = elgg_view_layout('sidebar_boxes', $sidebar, $content);
page_draw($title, $body);
