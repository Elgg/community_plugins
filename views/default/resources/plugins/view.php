<?php
/**
 * View a plugin project or release
 */

$project_guid = get_input('plugin');
elgg_entity_gatekeeper($project_guid, 'object', PluginProject::SUBTYPE);

$project = get_entity($project_guid);

elgg_set_page_owner_guid($project->getOwnerGUID());

elgg_push_breadcrumb(elgg_echo('plugins'), 'plugins');
elgg_push_breadcrumb($project->title);

// grab the entity and sidebar views
$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));
$content = elgg_view_entity($project, array(
	'full_view' => TRUE,
));

$title = $project->title;

$body = elgg_view_layout("one_sidebar", array(
	'title' => $title,
	'sidebar' => $sidebar,
	'content' => $content,
	'entity' => $project,
));


echo elgg_view_page($project->title, $body, 'default', [
	'entity' => $project,
]);
