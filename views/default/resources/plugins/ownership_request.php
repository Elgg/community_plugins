<?php

elgg_gatekeeper();

$project_guid = get_input('plugin');
elgg_entity_gatekeeper($project_guid, 'object', PluginProject::SUBTYPE);

$project = get_entity($project_guid);

$instructions = elgg_view('output/longtext', [
	'value' => elgg_echo('plugins:project:request_ownership:desc'),
]);

$form = elgg_view_form('plugins/request_ownership', [], ['project' => $project]);

$sidebar = elgg_view('plugins/project_sidebar', ['entity' => $project]);

$title = elgg_echo('plugins:title:request_ownership', [$project->title]);

$body = elgg_view_layout("one_sidebar", [
	'title' => $title,
	'sidebar' => $sidebar,
	'content' => $instructions . $form,
]);

echo elgg_view_page($title, $body);
