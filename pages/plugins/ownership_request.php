<?php

$project = get_entity(get_input('plugin'));

if (!$project) {
  register_error(elgg_echo('plugins:action:invalid_project'));
  forward(REFERER);
}

$instructions = elgg_view('output/longtext', array(
	'value' => elgg_echo('plugins:project:request_ownership:desc'),
));

$form = elgg_view_form('plugins/request_ownership', array(), array('project' => $project));

$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:title:request_ownership', array($project->title));

$body = elgg_view_layout("one_sidebar", array(
	'title' => $title,
	'sidebar' => $sidebar,
	'content' => $instructions . $form,
));

echo elgg_view_page($title, $body);