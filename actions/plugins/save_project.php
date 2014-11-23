<?php
/**
 * Update a plugin project
 */

namespace Elgg\CommunityPlugins;

elgg_make_sticky_form('community_plugins');

// Get variables
$title = strip_tags(get_input("title"));
$desc = plugins_strip_tags(get_input("description"));
$tags = get_input("tags");
$access_id = (int) get_input("project_access_id", ACCESS_PUBLIC);
$donate = strip_tags(get_input('donate'));
$license = get_input('license');
$homepage = strip_tags(get_input('homepage'));
$repo = strip_tags(get_input('repo'));
$summary = strip_tags(elgg_substr(get_input('summary'), 0, 250));
$plugincat = get_input('plugincat');
$plugin_type = get_input('plugin_type');
if ($plugin_type != 'theme' && $plugin_type != 'languagepack') {
	$plugin_type = 'plugin';
}

$guid = (int) get_input('plugins_guid');

if (!$plugin_project = get_entity($guid)) {
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward("/plugins/" . elgg_get_logged_in_user_entity()->username);
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

if (!$plugin_project->canEdit()) {
	register_error(elgg_echo('plugins:error:permissions'));
	forward(REFERER);
}

$plugin_project->access_id = $access_id;
$plugin_project->title = $title;
$plugin_project->description = $desc;
$plugin_project->license = $license;
$plugin_project->homepage = $homepage;
$plugin_project->repo = $repo;
$plugin_project->donate = $donate;
$plugin_project->plugincat = $plugincat;
$plugin_project->summary = $summary;
$plugin_project->plugin_type = $plugin_type;
$plugin_project->tags = string_to_tag_array($tags);

$result = $plugin_project->save();

if ($result) {
	// check for any project images and associate them with the project
	$max_num_images = 4;
	for ($i=1; $i<=$max_num_images; $i++) {
		if (!array_key_exists("image_$i", $_FILES)) {
			continue;
		}

		$desc = get_input("image_{$i}_desc");

		$plugin_project->saveImage("image_$i", $desc, $i);
	}

	system_message(elgg_echo("plugins:project:saved"));

} else {
	register_error(elgg_echo("plugins:error:uploadfailed"));
}

elgg_clear_sticky_form('community_plugins');
forward($plugin_project->getURL());
