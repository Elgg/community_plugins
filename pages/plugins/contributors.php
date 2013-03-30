<?php

$guid = get_input('guid');

$project = get_entity($guid);

if (!$project || !$project->canEdit()) {
  register_error("Invalid Project");
  forward(REFERER);
}

$content = elgg_view_form('plugins/add_contributors', array(), array('project' => $project));
$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = "Add Contributors: {$project->title}";

$body = elgg_view_layout("one_sidebar", array(
'title' => $title,
'sidebar' => $sidebar,
'content' => $content,
));

echo elgg_view_page($title, $body);