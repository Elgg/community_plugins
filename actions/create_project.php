<?php
/**
 * Elgg plugin project creation action
 */


// Get variables
$title = strip_tags(get_input("title"));
// no href or img tags in description
$description = strip_tags(get_input("description"), '<p><strong><em><span><ul><li><ol><blockquote>');
$tags = get_input("tags");
$plugin_type = get_input('plugin_type');

if ($plugin_type != 'theme' && $plugin_type != 'languagepack') {
	$plugin_type = 'plugin';
}

$summary = strip_tags(elgg_substr(get_input('summary'), 0, 250));
$release_notes = strip_tags(get_input('release_notes'), '<p><strong><em><span><ul><li><ol><blockquote>');
$homepage = strip_tags(get_input('homepage'));
$donate = strip_tags(get_input('donate', ''));
$repo = strip_tags(get_input('repo'));
$elgg_version = get_input('elgg_version', 'Not specified');
$comments = get_input('comments', 'yes');
$version = strip_tags(get_input('version', 'Not specified'));
$license = get_input('license', 'none');
$plugincat = get_input('plugincat', 'uncategorized');
$recommended = get_input('recommended', FALSE);

$project_access_id = get_input("project_access_id", ACCESS_PUBLIC);
$release_access_id = get_input('release_access_id', ACCESS_PUBLIC);
$user = get_loggedin_user();

// We're only allowing archives.
if (!substr_count($_FILES['upload']['name'],'.tar.gz')
	&& !substr_count($_FILES['upload']['name'],'.tgz')
	&& !substr_count($_FILES['upload']['name'],'.zip')) {
		register_error(elgg_echo('plugins:files:badformat'));
		forward($CONFIG->wwwroot . "pg/plugins/" . $container_user->username);
} else {
	if (substr_count($_FILES['upload']['name'],'.tar.gz')
	|| substr_count($_FILES['upload']['name'],'.tgz')) {
		$mimetype = 'application/x-gzip';
	} else {
		$mimetype = 'application/zip';
	}
}

if ($license == 'none' || !array_key_exists($license, $CONFIG->gpllicenses)) {
	register_error(elgg_echo('plugins:files:badlicense'));
	forward($_SERVER['HTTP_REFERER']);
}

// Create the plugin project
$plugin_project = new ElggObject();
$plugin_project->subtype = "plugin_project";
$plugin_project->owner_guid = $user->getGUID();
$plugin_project->container_guid = $user->getGUID();
$plugin_project->access_id = $project_access_id;
$plugin_project->title = $title;
$plugin_project->description = $description;
$plugin_project->tags = explode(',', $tags);
$plugin_project->plugincat = $plugincat;
$plugin_project->license = $license;
$plugin_project->summary = $summary;
$plugin_project->homepage = $homepage;
$plugin_project->repo = $repo;
$plugin_project->donate = $donate;
$plugin_project->digg = 0;
//$plugin_project->elgg_version = $elgg_version;
$plugin_project->plugin_type = $plugin_type;
$result = $plugin_project->save();

// Extract file and save to default filestore (for now)
$prefix = "plugins/";
$file = new PluginRelease();
$filestorename = strtolower(time() . $_FILES['upload']['name']);
$file->title = $plugin_project->title;
$file->setFilename($prefix . $filestorename);
$file->setMimetype($mimetype);
$file->originalfilename = $_FILES['upload']['name'];
$file->subtype="plugin_release";
$file->access_id = $release_access_id;
$file->comments = $comments;
$uf = get_uploaded_file('upload');
if (!$uf) {
	register_error(elgg_echo("plugins:uploadfailed"));
	forward($_SERVER['HTTP_REFERER']);
	die();
}
$file->open("write");
$file->write($uf);
$file->close();

//$file->title = $title;
//$file->description = $desc;
$file->container_guid = $plugin_project->getGUID();
$file->save();
$file->version = $version;
$file->release_notes = $release_notes;
$file->elgg_version = $elgg_version;
$file->digg = 0;
$file->download_num = 0;
//now create a relationship between the plugin project and the uploaded plugin file
if ($result && $file){
	$add_relationship = add_entity_relationship($plugin_project->guid, 'is_plugin', $file->guid);
}

if ($add_relationship) {
	// check for any project images and associate them with the project
	$prefix = "plugins/";
	for ($i=1; $i<=4; $i++) {
		if (array_key_exists("image_$i", $_FILES)
		&& ($_FILES["image_$i"]['error'] == 0)
		&& ($desc = get_input("image_{$i}_desc", FALSE))) {
			$info = $_FILES["image_$i"];


			// delete original image if exists
			$options = array(
				'relationship_guid' => $plugin_project->getGUID(),
				'relationship' => 'image',
				'metadata_name_value_pair' => array('name' => 'project_image', 'value' => "$i")
			);

			if ($old_image = elgg_get_entities_from_relationship($options)) {
				if ($old_image[0] instanceof ElggFile) {
					$old_image[0]->delete();
				}
			}

			$image = new ElggFile();
			$store_name_base = $prefix . strtolower($plugin_project->getGUID() . "_image_$i");
			$image->title = get_input("image_{$i}_desc");
			$image->access_id = $plugin_project->access_id;
			$image->setFilename($store_name_base . '.jpg');
			$image->setMimetype('image/jpeg');
			$image->originalfilename = $info['name'];
			$image->access_id = $plugin_project->access_id;
			// tag image to delete if needed
			$image->project_image = $i;
			$uf = get_uploaded_file("image_$i");

			if ($uf && $image->open("write") && $image->write($uf)
			&& $image->close() && $image->save()) {
				// create a thumbnail
				add_entity_relationship($plugin_project->guid, 'image', $image->guid);

				try {
					$thumbnail = get_resized_image_from_existing_file($image->getFilenameOnFilestore(), 60, 60, true);
				} catch (Exception $e) {
					$thumbnail = false;
				}

				$thumb = new ElggFile();
				$thumb->setMimeType('image/jpeg');
				$thumb->access_id = $plugin_project->access_id;
				$thumb->setFilename($store_name_base . '_thumb.jpg');
				$thumb->open("write");
				if ($thumb->write($thumbnail) && $thumb->save()) {
					$image->thumbnail_guid = $thumb->getGUID();
				} else {
					$thumb->delete();
					$image->delete();
					register_error("Could not save image $i");
				}
			} else {
				register_error("Could not save image $i");
			}
		}
	}

	add_to_river('river/object/plugin_project/create', 'create', $user->getGUID(), $plugin_project->getGUID());
	system_message(elgg_echo("plugins:saved"));
} else {
	register_error(elgg_echo("plugins:uploadfailed"));
}

if ($recommended == 'yes') {
	$plugin_project->recommended_release_guid = $file->getGUID();
}

forward($plugin_project->getURL());
