<?php
/**
 * Elgg Ratings: add rating action
 */

// Make sure we're logged in; forward to the front page if not
if (!isloggedin()) forward();

// Get input
$project_guid = (int) get_input('guid');
// Get the project
$plugin_project = get_entity($project_guid);

// Let's see if we can get an entity with the specified GUID
if ($plugin_project) {
	//double check to see if the user has already dugg the plugin
	if(already_dugg($plugin_project)){
		system_message(elgg_echo("plugins:alreadydugg"));
	} else {
		//$digg_num = $plugin_project->digg + 1;
		//$plugin_project->digg = (int) $digg_num;
		if ($plugin_project->annotate('plugin_digg', 1, $plugin_project->access_id, $_SESSION['guid'])){
			//create a relationship between user and plugin project so they can only digg once
			add_entity_relationship($_SESSION['user']->guid, 'has_dugg', $plugin_project->guid);
			system_message(elgg_echo("plugins:diggit"));
		}
	}
} else {
	system_message(elgg_echo("ratings:notfound"));
}

// Forward to the plugin
$url = $vars['url'] . "mod/community_plugins/read.php?guid=" . $project_guid;
forward($url);