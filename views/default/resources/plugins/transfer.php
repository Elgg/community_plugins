<?php

elgg_admin_gatekeeper();

$project_guid = get_input('plugin');
elgg_entity_gatekeeper($project_guid, 'object', PluginProject::SUBTYPE);

$project = get_entity($project_guid);

$content = elgg_view_form('plugins/admin/transfer', array(), array('project' => $project));
$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:title:transfer_plugin', array($project->title));

$body = elgg_view_layout("one_sidebar", array(
	'title' => $title,
	'sidebar' => $sidebar,
	'content' => $content,
));

echo elgg_view_page($title, $body);
