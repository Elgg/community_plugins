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

$github_owner = get_input('github_owner', '');
$github_repo = get_input('github_repo', '');
$github_releases = (array) get_input('github_releases', []);

if (empty($github_releases) && (isset($_FILES['upload']['name']) && $_FILES['upload']['error'] != UPLOAD_ERR_OK)) {
	// We need an uploaded file to create a release if github releases were not provided
	$error = elgg_get_friendly_upload_error($_FILES['upload']['error']);
	register_error($error);
	forward(REFERRER);
}

$user = elgg_get_logged_in_user_entity();

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
$plugin_project->setGithubRepo($github_owner, $github_repo);
$plugin_project->github_access_id = get_input('github_access_id', $plugin_project->access_id);
$plugin_project->github_comments = get_input('github_comments', 'yes');
if (!$plugin_project->save()) {
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward(REFERRER);
}

$releases = [];

if (!empty($github_releases)) {
	foreach ($github_releases as $github_release) {
		$release = $plugin_project->addReleaseFromGithub($github_release);
		if ($release) {
			$releases[] = $release;
		}
	}
} else if ($_FILES['upload']['error'] == UPLOAD_ERR_OK) {
	$release = $plugin_project->addReleaseFromUpload('upload', [
		'release_notes' => get_input('release_notes', ''),
		'elgg_version' => get_input('elgg_version', []),
		'comments' => get_input('comments', 'yes'),
		'version' => strip_tags(get_input('version', '0.0')),
		'recommended' => get_input('recommended', []),
		'access_id' => get_input('release_access_id', $plugin_project->access_id),
	]);
	if ($release) {
		$releases[] = $release;
	}
}

if (empty($releases)) {
	$plugin_project->delete();
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward(REFERRER);
}

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
