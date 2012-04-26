<?php
/**
 * Action for transferring a plugin
 */

global $CONFIG;

$project_guid = (int)get_input('project_guid');
$user_guid = (int)get_input('user_guid');

$project = get_entity($project_guid);
$user = get_entity($user_guid);

if (!$project instanceof PluginProject) {
	register_error('GUID must be of a plugin project');
	forward(REFERER);
}

if (!$user instanceof ElggUser) {
	register_error('Invalid user');
	forward(REFERER);
}

$original_owner = get_entity($project->owner_guid);

// change project owner and container
$project->owner_guid = $user_guid;
$project->container_guid = $user_guid;
$project->save();

// move screenshots to new location
$img_files = elgg_get_entities_from_relationship(array(
	'relationship_guid' => $project->getGUID(),
	'relationship' => 'image'
));

foreach ($img_files as $file) {
	// find thumbnails
	$thumb = get_entity($file->thumbnail_guid);
	if ($thumb) {
		change_file_owner($thumb, $user);
	}

	change_file_owner($file, $user);
}

// change releases owner
$params = array(
	'types' => 'object',
	'subtypes' => 'plugin_release',
	'container_guids' => $project->guid,
	'limit' => 0,
);
$releases = elgg_get_entities($params);
foreach ($releases as $release) {
	change_file_owner($release, $user);
}

system_message("$project->title has been transferred from $original_owner->name to $user->name");
forward(REFERER);

function change_file_owner($file, $new_owner) {
	// fetch data.
	$data = $file->grabFile();
	$old_filename = $file->getFilenameOnFilestore();

	// change owner and save to get the correct matrix.
	$file->owner_guid = $new_owner->getGUID();
	if (!$file->save()) {
		return false;
	}

	$file->open('write');
	$file->write($data);
	$file->close();

	unlink($old_filename);
	return $file->guid;
}