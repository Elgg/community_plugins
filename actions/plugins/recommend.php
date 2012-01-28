<?php
/**
 * Add recommendation action
 */

// Get input
$project_guid = (int) get_input('guid');
// Get the project
$plugin_project = get_entity($project_guid);

// Let's see if we can get an entity with the specified GUID
if ($plugin_project) {
	//double check to see if the user has already dugg the plugin
	if (plugins_is_dugg($plugin_project)){
		system_message(elgg_echo("plugins:alreadydugg"));
	} else {
		if ($plugin_project->annotate('plugin_digg', 1, $plugin_project->access_id, elgg_get_logged_in_user_guid())){
			//create a relationship between user and plugin project so they can only recommend once
			add_entity_relationship(elgg_get_logged_in_user_guid(), 'has_dugg', $plugin_project->guid);
			system_message(elgg_echo("plugins:diggit"));
		}
	}
} else {
	system_message(elgg_echo("ratings:notfound"));
}

$url = $plugin_project->getURL();
forward($url);
