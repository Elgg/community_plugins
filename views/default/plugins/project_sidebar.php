<?php
/**
 * Wrapper for plugin project sidebar
 */

//get the plugin project
$project = $vars['entity'];


// Administration
if ($project->canEdit()){
	$title = elgg_echo('Project Admin');
	$content = elgg_view('plugins/project_sidebar/admin', array('entity' => $project));
	echo elgg_view_module('aside', $title, $content);
}

// Links
if ($project->author_homepage || $project->homepage || $project->repo || $project->donate) {
	$title = elgg_echo('Project Info');
	$content = elgg_view('plugins/project_sidebar/info', array('entity' => $project));
	echo elgg_view_module('aside', $title, $content);
}

// Statistics
$title = elgg_echo('Stats');
$content = elgg_view('plugins/project_sidebar/stats', array('entity' => $project));
echo elgg_view_module('aside', $title, $content);


// Other plugins by the same user
$all_user_plugins_count = elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => 'plugin_project',
	'owner_guid' => $project->owner_guid,
	'count' => TRUE,
));

if ($all_user_plugins_count > 1) {
	$title = 'Other Projects';
	$content = elgg_view('plugins/project_sidebar/other', array('entity' => $project));
	echo elgg_view_module('aside', $title, $content);
}

// Contributors
$contributors_count = elgg_get_entities_from_relationship(array(
	'type' => 'user',
	'relationship' => PLUGINS_CONTRIBUTOR_RELATIONSHIP,
	'relationship_guid' => $project->guid,
	'inverse_relationship' => TRUE,
	'count' => TRUE
));

if ($contributors_count) {
  $title = 'Contributors';
  $content = elgg_view('plugins/project_sidebar/contributors', array('entity' => $project));
  echo elgg_view_module('aside', $title, $content);
}