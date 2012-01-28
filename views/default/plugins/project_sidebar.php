<?php
/**
 * Wrapper for plugin project sidebar
 */

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

// add reported content so users can report bad plugins
// @todo Elgg 1.8 moves reported content to footer so this won't be needed
if (elgg_is_logged_in()) {
	if (elgg_view_exists('reportedcontent/owner_block')) {
		echo '<div class="sidebarBox">';
		echo elgg_view('reportedcontent/owner_block');
		echo '</div>';
	}
}
