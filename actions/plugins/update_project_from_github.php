<?php
/**
 * Upload new release
 */

// Get variables
$project_guid = get_input("guid");

// grab the plugin project and check permissions
$plugin_project = get_entity($project_guid);
if (!$plugin_project || !$plugin_project->canEdit()) {
	register_error(elgg_echo('plugins:error:permissions'));
	forward(REFERER);
}

$repo = $plugin_project->github_repo;

if (!isset($repo)) {
    register_error("No github repo associated with this plugin");
    forward(REFERER);
}

$tags = json_decode(file_get_contents("https://api.github.com/repos/$repo/tags"));

if (!$tags) {
    register_error("Failed to fetch tags from github");
    forward(REFERER);
}

foreach ($tags as $tag) {
    if (!$plugin_project->getReleaseFromVersion($tag->name)) {
        $newest_tag = $tag;
        break;
    }
}

if (!isset($newest_tag)) {
    system_message("No new tags");
    forward(REFERER);
}


$version = $newest_tag->name;

// Extract file and save to default filestore (for now)
$prefix = "plugins/";
$filestorename = $prefix . strtolower(time() . "$version.zip");
$release = new PluginRelease();
$release->title = $plugin_project->title;
$release->setFilename($filestorename);

// TODO(evan): Save mimetype
// $release->setMimetype($mimetype);
$release->originalfilename = "$version.zip";
$release->access_id = $plugin_project->access_id;
$release->container_guid = $plugin_project->getGUID();
$release->version = $version;

if (!$release->save()) {
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward($plugin_project->getURL());
}

// Write the file
try {
    $zipball = file_get_contents($newest_tag->zipball_url);
    $release->open('write');
    $release->write($zipball);
    $release->close();
} catch (Exception $e) {
	register_error(elgg_echo("plugins:error:uploadfailed"));
	forward(REFERER);
}

$release->setHash();

add_to_river('river/object/plugin_release/create', 'create', elgg_get_logged_in_user_guid(), $release->guid);
plugins_send_notifications($release);
system_message(elgg_echo("plugins:release:saved"));

forward($release->getURL());
