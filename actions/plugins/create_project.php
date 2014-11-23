<?php

/**
 * Elgg plugin project creation action
 */

namespace Elgg\CommunityPlugins;

use PluginProject;
use PluginRelease;

elgg_make_sticky_form('community_plugins');

// Get variables
$title = strip_tags(get_input("title"));
$description = plugins_strip_tags(get_input("description"));
$tags = get_input("tags");
$summary = strip_tags(elgg_substr(get_input('summary'), 0, 250));
$homepage = strip_tags(get_input('homepage'));
$donate = strip_tags(get_input('donate'));
$repo = strip_tags(get_input('repo'));
$license = get_input('license');
$plugincat = get_input('plugincat', 'uncategorized');
$project_access_id = get_input("project_access_id", ACCESS_PUBLIC);
$plugin_type = get_input('plugin_type');
if ($plugin_type != 'theme' && $plugin_type != 'languagepack') {
	$plugin_type = 'plugin';
}

$release_notes = plugins_strip_tags(get_input('release_notes'));
$elgg_version = get_input('elgg_version', false);
$comments = get_input('comments', 'yes');
$version = strip_tags(get_input('version'));
$recommended = get_input('recommended', array());
$release_access_id = get_input('release_access_id', ACCESS_PUBLIC);

$user = elgg_get_logged_in_user_entity();


// validate data
if (!$title) {
	register_error(elgg_echo('plugins:error:notitle'));
	forward(REFERER);
}
$licenses = elgg_get_config('gpllicenses');
if ($license == 'none' || !array_key_exists($license, $licenses)) {
	register_error(elgg_echo('plugins:error:badlicense'));
	forward(REFERER);
}
$mimetype = get_mimetype('upload');
if (!$mimetype) {
	register_error(elgg_echo('plugins:error:badformat'));
	forward(REFERER);
}

// version is sent but null, so get_input doesn't use defaults.
if (!$version) {
	register_error(elgg_echo('plugins:error:no_version'));
	forward(REFERER);
}

// we require an elgg version now
if (!$elgg_version) {
	register_error(elgg_echo('plugins:error:no_elgg_version'));
	forward(REFERER);
}

// Create the plugin project
$plugin_project = new PluginProject();
$plugin_project->owner_guid = $user->getGUID();
$plugin_project->container_guid = $user->getGUID();
$plugin_project->access_id = $project_access_id;
$plugin_project->title = $title;
$plugin_project->description = $description;
$plugin_project->tags = string_to_tag_array($tags);
$plugin_project->plugincat = $plugincat;
$plugin_project->license = $license;
$plugin_project->summary = $summary;
$plugin_project->homepage = $homepage;
$plugin_project->repo = $repo;
$plugin_project->donate = $donate;
$plugin_project->digg = 0;
$plugin_project->plugin_type = $plugin_type;
$plugin_project->save();

// Extract file and save to default filestore (for now)
$prefix = "plugins/";
$filestorename = $prefix . strtolower(time() . $_FILES['upload']['name']);
$release = new PluginRelease();
$release->title = $plugin_project->title;
$release->setFilename($filestorename);
$release->setMimetype($mimetype);
$release->originalfilename = $_FILES['upload']['name'];
$release->access_id = $release_access_id;
$release->container_guid = $plugin_project->getGUID();
$release->version = $version;
$release->release_notes = $release_notes;
$release->elgg_version = $elgg_version;
$release->comments = $comments;
$release->save();

if ($release->saveArchive('upload') != TRUE) {
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward(REFERER);
}

if (!$plugin_project->getGUID() || !$release->getGUID()) {
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward(REFERER);
}

$release->setRecommended($recommended);

// check for any project images and associate them with the project
$max_num_images = 4;
for ($i = 1; $i <= $max_num_images; $i++) {
	if (!array_key_exists("image_$i", $_FILES)) {
		continue;
	}

	$desc = get_input("image_{$i}_desc");

	$plugin_project->saveImage("image_$i", $desc, $i);
}

elgg_create_river_item(array(
	'view' => 'river/object/plugin_project/create',
	'action_type' => 'create',
	'subject_guid' => $user->getGUID(),
	'object_guid' => $plugin_project->getGUID(),
));

system_message(elgg_echo("plugins:project:saved"));

elgg_clear_sticky_form('community_plugins');
forward($plugin_project->getURL());
