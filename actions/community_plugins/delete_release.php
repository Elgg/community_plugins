<?php
/**
 * Elgg plugin project delete release
 */

$guid = (int) get_input('release_guid');

$release = get_entity($guid);
if (!$release) {
	register_error(elgg_echo("plugins:error:deletefailed"));
	forward(REFERER);
}

$project = get_entity($release->container_guid);
if (!$project) {
	register_error(elgg_echo("plugins:error:deletefailed"));
	forward(REFERER);
}

if (!($release instanceof PluginRelease) || !$release->canEdit()) {
	register_error(elgg_echo("plugins:error:deletefailed"));
	forward(REFERER);
}

$release->delete();
if ($project->recommended_release_guid == $guid) {
	unset($project->recommended_release_guid);
}

system_message(elgg_echo("plugins:release:deleted"));

forward($project->getURL());
