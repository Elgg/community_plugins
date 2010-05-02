<?php
/**
 * Elgg plugin project delete release
 */
action_gatekeeper();

$guid = (int) get_input('release_guid');

if (($release = get_entity($guid))
&& ($project = get_entity($release->container_guid))
&& $release instanceof FilePluginFile
&& $release->getSubtype() == 'plugin_file' && $release->canEdit()
&& $release->delete()) {
	if ($project->recommended_release_guid == $guid) {
		unset($project->recommended_release_guid);
	}
	system_message(elgg_echo("plugins:deleted"));
} else {
	register_error(elgg_echo("plugins:deletefailed"));
}

forward($_SERVER['HTTP_REFERER']);