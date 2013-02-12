<?php
/**
 * Upload new release
 */

// Get variables
$project_guid = get_input("guid");
$recommended = get_input('recommended', 'no');
$elgg_version = get_input('elgg_version', 'Not specified');
$version = strip_tags(get_input('version'));
$access_id = (int) get_input("release_access_id", ACCESS_PUBLIC);
$comments = get_input('comments', 'yes');
$release_notes = plugins_strip_tags(get_input('release_notes'));

// validate data
$mimetype = plugins_get_mimetype('upload');
if (!$mimetype) {
	register_error(elgg_echo('plugins:error:badformat'));
	forward(REFERER);
}

// grab the plugin project and check permissions
$plugin_project = get_entity($project_guid);
if (!$plugin_project || !$plugin_project->canEdit()) {
	register_error(elgg_echo('plugins:error:permissions'));
	forward(REFERER);
}

if (!$version) {
	register_error(elgg_echo('plugins:error:no_version'));
	forward(REFERER);
}

//ensure unique version string
$releases = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'plugin_release',
			'container_guid' => $plugin_project->guid,
			'metadata_name' => 'version',
			'metadata_value' => $version,
			'limit' => 1,
		));

if ($releases) {
	register_error(elgg_echo('plugins:error:duplicate_version'));
	forward(REFERER);
}

// Extract file and save to default filestore (for now)
$prefix = "plugins/";
$filestorename = $prefix . strtolower(time() . $_FILES['upload']['name']);
$release = new PluginRelease();
$release->title = $plugin_project->title;
$release->setFilename($filestorename);
$release->setMimetype($mimetype);
$release->originalfilename = $_FILES['upload']['name'];
$release->access_id = $access_id;
$release->container_guid = $plugin_project->getGUID();
$release->version = $version;
$release->release_notes = $release_notes;
$release->elgg_version = $elgg_version;
$release->comments = $comments;

if (!$release->save()) {
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward($plugin_project->getURL());
}

if ($release->saveArchive('upload') != TRUE) {
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward(REFERER);
}

if ($recommended == 'yes') {
	$plugin_project->recommended_release_guid = $release->getGUID();
}

$release->setHash();

add_to_river('river/object/plugin_release/create', 'create', elgg_get_logged_in_user_guid(), $release->guid);
plugins_send_notifications($release);
system_message(elgg_echo("plugins:release:saved"));

forward($release->getURL());
