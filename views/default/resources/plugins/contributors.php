<?php

$project_guid = get_input('plugin');
elgg_entity_gatekeeper($project_guid, 'object', PluginProject::SUBTYPE);

$project = get_entity($project_guid);
if (!$project->canEdit()) {
	register_error(elgg_echo('plugins:action:invalid_project'));
	forward(REFERER);
}

$content = elgg_view_form('plugins/add_contributors', [], ['project' => $project]);
$sidebar = elgg_view('plugins/project_sidebar', ['entity' => $project]);

$title = elgg_echo('plugins:add:contributor', [$project->title]);

$body = elgg_view_layout("one_sidebar", [
	'title' => $title,
	'sidebar' => $sidebar,
	'content' => $content,
]);

echo elgg_view_page($title, $body);
