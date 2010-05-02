<?php
/**
 * Elgg plugin delete project image
 */
action_gatekeeper();

$project= get_entity(get_input('project_guid', 0));
$image = get_entity(get_input('image_guid', 0));

if (!$project->canEdit()) {
	register_error(elgg_echo("plugins:deletefailed"));
	forward($_SERVER['HTTP_REFERER']);
}

if ($project && $image && $project instanceof ElggObject
&& $project->canEdit() && $project->getSubtype() == 'plugin_project') {
	if (check_entity_relationship($project->getGUID(), 'image', $image->getGUID())) {
		// remove thumbnail
		if ($thumb = get_entity($image->thumbnail_guid) && $thumb instanceof ElggFile) {
			$thumb->delete();
		}
		$test = $image->delete();
		if ($test) {
			system_message(elgg_echo('Image deleted.'));
		} else {
			register_error(elgg_echo("plugins:deletefailed"));
		}
	}
} else {
	register_error(elgg_echo("plugins:deletefailed"));
}

forward($_SERVER['HTTP_REFERER']);