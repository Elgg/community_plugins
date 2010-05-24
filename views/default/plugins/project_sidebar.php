<?php
/**
 * Plugin project sidebar
 **/

//get the plugin project
$project = $vars['entity'];


if ($project->canEdit()){
	echo elgg_view('plugins/project_sidebar/admin', array('entity' => $project));
}

echo elgg_view('plugins/project_sidebar/info', array('entity' => $project));

echo elgg_view('plugins/project_sidebar/stats', array('entity' => $project));

echo elgg_view('plugins/project_sidebar/releases', array('entity' => $project));

echo elgg_view('plugins/project_sidebar/images', array('entity' => $project));

echo elgg_view('plugins/project_sidebar/other', array('entity' => $project));

