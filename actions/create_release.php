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

if ($release->savePluginFile('upload') != TRUE) {
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward(REFERER);
}

if (!$release->save()) {
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward($plugin_project->getURL());
}

if ($recommended == 'yes') {
	$plugin_project->recommended_release_guid = $release->getGUID();
}

add_to_river('river/object/plugin_release/create', 'create', get_loggedin_userid(), $release->guid);
system_message(elgg_echo("plugins:release:saved"));

forward($release->getURL());
