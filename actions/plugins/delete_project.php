<?php
/**
 * Elgg plugin project delete
 */

$guid = (int) get_input('project_guid');

if (($project = get_entity($guid))
&& $project instanceof ElggObject
&& $project->getSubtype() == 'plugin_project'
&& $project->canEdit()
&& $project->delete()
) {
	// remove any files associated
	$img_files = elgg_get_entities_from_relationship(array(
		'relationship_guid' => $guid,
		'relationship' => 'image'
	));

	if ($img_files && is_array($img_files)) {
		foreach ($img_files as $file) {
			if ($thumb = get_entity($file->thumbnail_guid)) {
				$thumb->delete();
			}
			$file->delete();
		}
	}

	system_message(elgg_echo("plugins:project:deleted"));
} else {
	register_error(elgg_echo("plugins:error:deletefailed"));
}

forward("plugins/developer/" . elgg_get_logged_in_user_entity()->username);
