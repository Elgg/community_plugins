<?php

$project = get_entity(get_input('plugin'));

if (!$project || !$project->canEdit()) {
  register_error(elgg_echo('plugins:action:invalid_project'));
  forward(REFERER);
}

$content = elgg_view_form('plugins/admin/transfer', array(), array('project' => $project));
$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:title:transfer_plugin', array($project->title));

$body = elgg_view_layout("one_sidebar", array(
	'title' => $title,
	'sidebar' => $sidebar, 
	'content' => $content,
));

echo elgg_view_page($title, $body);