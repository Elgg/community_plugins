<?php
/**
 * Update plugin release
 */

namespace Elgg\CommunityPlugins;
use PluginRelease;

elgg_make_sticky_form('community_plugins');

// Get variables
$access_id = (int) get_input('release_access_id');
$version = strip_tags(get_input('version'));
$release_notes = plugins_strip_tags(get_input('release_notes'));
$elgg_version = get_input('elgg_version');
$comments = get_input('comments', 'yes');
$recommended = get_input('recommended', array());
$guid = (int) get_input('release_guid');

// check permissions and existence of release
if (!($release = get_entity($guid)) ||
	!($project = get_entity($release->container_guid)) ||
	!($release instanceof PluginRelease) ||
	!$release->canEdit() ) {

	register_error(elgg_echo('plugins:action:invalid_access'));
	forward("/plugins/developer/" . elgg_get_logged_in_user_entity()->username);
}

// save release entity info
$release->access_id = $access_id;
$release->version = $version;
$release->release_notes = $release_notes;
$release->comments = $comments;
$release->elgg_version = $elgg_version;

$release->setRecommended($recommended);

if ($release->save()) {
	system_message(elgg_echo("plugins:release:saved"));
} else {
	register_error(elgg_echo("plugins:error:uploadfailed"));
}

elgg_clear_sticky_form('community_plugins');
forward($release->getURL());
