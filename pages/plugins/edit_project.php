<?php
/**
 * Edit plugin project
 */

gatekeeper();

$project_guid = (int) get_input('project_guid');
$project = get_entity($project_guid);

if (!$project || !$project->canEdit()) {
	register_error('Unknown project or insufficient access.');
	forward();
}

set_page_owner($project->owner_guid);

$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:edit:project');

$content = elgg_view_title($title);
$content .= elgg_view("plugins/forms/edit_project", array('project' => $project));

$body = elgg_view_layout('sidebar_boxes', array(
	'area1' => $sidebar, 
	'area2' => $content,
));
echo elgg_view_page($title, $body);
