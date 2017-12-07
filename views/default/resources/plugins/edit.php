<?php
/**
 * Edit plugin project
 */

gatekeeper();

$project_guid = get_input('plugin');
elgg_entity_gatekeeper($project_guid, 'object', PluginProject::SUBTYPE);

$project = get_entity($project_guid);
if (!$project->canEdit()) {
	register_error(elgg_echo('plugins:action:invalid_access'));
	forward();
}

elgg_set_page_owner_guid($project->owner_guid);

elgg_push_breadcrumb(elgg_echo('plugins'), 'plugins');
elgg_push_breadcrumb($project->title, $project->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

$sidebar = elgg_view('plugins/project_sidebar', ['entity' => $project]);

$title = elgg_echo('plugins:edit:project');

$content = elgg_view_form("plugins/save_project", [
	'enctype' => 'multipart/form-data',
], [
	'project' => $project,
]);

$body = elgg_view_layout('one_sidebar', [
    'title' => $title,
	'sidebar' => $sidebar,
	'content' => $content,
]);

echo elgg_view_page($title, $body);
