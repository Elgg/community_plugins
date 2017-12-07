<?php

elgg_admin_gatekeeper();

$project_guid = get_input('plugin');
elgg_entity_gatekeeper($project_guid, 'object', PluginProject::SUBTYPE);

$project = get_entity($project_guid);

$title = elgg_echo('plugins:requests:ownership');

$content = elgg_list_annotations(array(
	'guid' => $project->guid,
	'annotation_name' => 'ownership_request',
	'no_results' => elgg_echo('none'),
));

$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$body = elgg_view_layout('one_sidebar', array(
    'title' => $title,
	'sidebar' => $sidebar,
	'content' => $content,
));

echo elgg_view_page($title, $body);
