<?php
/**
 * Upload new release
 */

// Get variables
$project_guid = get_input("guid");
$recommended = get_input('recommended', 'no');
$elgg_version = get_input('elgg_version', 'Not specified');
$version = strip_tags(get_input('version'));
$access_id = (int) get_input("release_access_id");
$container_guid = (int) get_input('container_guid', 0);
$comments = get_input('comments', 'yes');
// strip out links and img tags
$release_notes = strip_tags(get_input('release_notes'), '<p><strong><em><span><ul><li><ol><blockquote>');

if (!$container_guid) {
	$container_guid = get_loggedin_userid();
}

// We're only allowing archives.
if (!substr_count($_FILES['upload']['name'],'.tar.gz')
	&& !substr_count($_FILES['upload']['name'],'.tgz')
	&& !substr_count($_FILES['upload']['name'],'.zip')) {
		register_error(elgg_echo('plugins:files:badformat'));
		forward($_SERVER['HTTP_REFERER']);
}

if (substr_count($_FILES['upload']['name'],'.tar.gz') ||
	substr_count($_FILES['upload']['name'],'.tgz')) {
	$mimetype = 'application/x-gzip';
} else {
	$mimetype = 'application/zip';
}

// grab the plugin project
$plugin_project = get_entity($project_guid);
if ($plugin_project && $plugin_project->canEdit()) {
	// Extract file and save to default filestore (for now)
	$prefix = "plugins/";

	$file = new FilePluginFile();
	$filestorename = strtolower(time().$_FILES['upload']['name']);
	$file->title = $plugin_project->title;
	$file->setFilename($prefix.$filestorename);
	$file->setMimetype($mimetype);
	$file->originalfilename = $_FILES['upload']['name'];
	$file->subtype="plugin_file";
	$file->access_id = $access_id;
	$file->elgg_version = $elgg_version;

	$uf = get_uploaded_file('upload');
	if (!$uf) {
		register_error(elgg_echo("plugins:uploadfailed"));
		forward($_SERVER['HTTP_REFERER']);
	}
	$file->open("write");
	$file->write($uf);
	$file->close();
	$file->container_guid = $plugin_project->getGUID();
	$file->version = $version;
	$file->release_notes = $release_notes;
	$file->comments = $comments;

	//now create a relationship between the plugin project and the newly uploaded plugin file
	if ($file->save()) {
		$add_relationship = add_entity_relationship($plugin_project->guid, 'is_plugin', $file->guid);
		if ($recommended == 'yes') {
			$plugin_project->recommended_release_guid = $file->getGUID();
		}
	}

	if ($add_relationship) {
		add_to_river('river/object/plugins/update','update',get_loggedin_userid(),$plugin_project->guid);
		system_message(elgg_echo("plugins:updated"));
	} else {
		register_error(elgg_echo("plugins:uploadfailed"));
	}
} else {
	system_message(elgg_echo("plugins:noproject"));
}

forward($CONFIG->wwwroot . "mod/community_plugins/read.php?guid=" . $project_guid);
