<?php
/**
 * Edit plugin project
 */

gatekeeper();

$project = get_entity(get_input('plugin'));

if (!$project || !$project->canEdit()) {
	register_error(elgg_echo('plugins:action:invalid_access'));
	forward();
}

elgg_set_page_owner_guid($project->owner_guid);

$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:edit:project');

$content = elgg_view_form("plugins/save_project", array(
	'enctype' => 'multipart/form-data',
), array(
	'project' => $project,
));

$body = elgg_view_layout('one_sidebar', array(
    'title' => $title,
	'sidebar' => $sidebar, 
	'content' => $content,
));
echo elgg_view_page($title, $body);
