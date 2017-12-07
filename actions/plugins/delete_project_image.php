<?php
/**
 * Elgg plugin delete project image
 */

$project = get_entity(get_input('project_guid', 0));
$image = get_entity(get_input('image_guid', 0));

if (!$project instanceof PluginProject || !$image instanceof ElggFile) {
	return elgg_error_response(elgg_echo('plugins:error:imagedeletefailed'));
}

if (!$project->canEdit()) {
	return elgg_error_response(elgg_echo('plugins:error:imagedeletefailed'));
}

if (!check_entity_relationship($project->getGUID(), 'image', $image->getGUID())) {
	return elgg_error_response(elgg_echo('plugins:error:imagedeletefailed'));
}

// remove thumbnail
$thumb = get_entity($image->thumbnail_guid);
if ($thumb instanceof ElggFile) {
	$thumb->delete();
}

if (!$image->delete()) {
	return elgg_error_response(elgg_echo('plugins:error:imagedeletefailed'));
}

return elgg_ok_response('', elgg_echo('plugins:action:delete_project_image'));
