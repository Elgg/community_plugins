<?php
/**
 * update plugin release
 */

// Get variables
$access_id = (int) get_input('release_access_id');
$version = strip_tags(get_input('version'));
$release_notes = strip_tags(get_input('release_notes'), '<p><strong><em><span><ul><li><ol><blockquote>');
$elgg_version = get_input('elgg_version');
$comments = get_input('comments', 'yes');
$recommended = get_input('recommended', 'no');

$guid = (int) get_input('release_guid');

if (($release = get_entity($guid))
&& ($project = get_entity($release->container_guid))
&& $release instanceof PluginRelease
&& $release->canEdit()) {

	// save release entity info
	$release->access_id = $access_id;
	$release->version = $version;
	$release->release_notes = $release_notes;
	$release->comments = $comments;

	// update recommended if required
	if ($recommended == 'yes') {
		$project->recommended_release_guid = $release->getGUID();
	}

	$username = get_entity($release->owner_guid)->username;

	if ($release->save()) {
		system_message(elgg_echo("plugins:release:saved"));
	} else {
		register_error(elgg_echo("plugins:uploadfailed"));
	}
	forward($release->getURL());
} else {
	register_error('Unknown or insufficient access to release');
	forward($CONFIG->wwwroot . "pg/plugins/developer/" . $_SESSION['user']->username);
}
