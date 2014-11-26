<?php
/**
 * View a plugin project or release
 */

$project = get_entity(get_input('plugin'));
if (!$project instanceof PluginProject) {
	register_error(elgg_echo('plugins:notfound'));
	forward('plugins/search');
}


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
));


echo elgg_view_page($project->title, $body);
