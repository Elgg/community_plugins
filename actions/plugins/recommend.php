<?php
/**
 * Add recommendation action
 */

// Get input
$project_guid = (int) get_input('guid');
// Get the project
$plugin_project = get_entity($project_guid);

// Let's see if we can get an entity with the specified GUID
if (!$plugin_project instanceof PluginProject) {
	register_error(elgg_echo("ratings:notfound"));
} elseif ($plugin_project->isDugg()){
	register_error(elgg_echo("plugins:alreadydugg"));
} elseif ($plugin_project->annotate('plugin_digg', 1, $plugin_project->access_id, elgg_get_logged_in_user_guid())){
	// create a relationship between user and plugin project so they can only recommend once
	$plugin_project->addDigg();
	system_message(elgg_echo("plugins:diggit"));
}
