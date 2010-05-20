<?php
/**
 * Elgg file browser save action
 */

global $CONFIG;
action_gatekeeper();
// Get variables
$title = strip_tags(get_input("title"));
$desc = strip_tags(get_input("description"), '<p><strong><em><span><ul><li><ol><blockquote>');
$tags = get_input("tags");
$access_id = (int) get_input("project_access_id");
$donate = strip_tags(get_input('donate', ''));
$license = get_input('license');
$homepage = strip_tags(get_input('homepage'));
$repo = strip_tags(get_input('repo'));
$summary = strip_tags(elgg_substr(get_input('summary'), 0, 250));
$plugincat = get_input('plugincat');
$plugin_type = get_input('plugin_type');
$recommended_guid = get_input('recommended_release_guid', 0);

$guid = (int) get_input('plugins_guid');

if (!$plugin_project = get_entity($guid)) {
	register_error(elgg_echo("plugins:uploadfailed"));
	forward($CONFIG->wwwroot . "pg/plugins/" . $_SESSION['user']->username);
	exit;
}

if ($license == $none || !array_key_exists($license, $CONFIG->gpllicenses)) {
	register_error(elgg_echo('plugins:files:badlicense'));
	forward($_SERVER['HTTP_REFERER']);
}

$result = false;

if ($plugin_project->canEdit()) {
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
	$plugin_project->recommended_release_guid = $recommended_guid;

	// Save tags
	$tags = explode(",", $tags);
	$plugin_project->tags = $tags;
	$result = $plugin_project->save();
}

if ($result) {
	// check for any project images and associate them with the project
	// C&P ftw.
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
	system_message(elgg_echo("plugins:saved"));
	add_to_river('river/object/plugins/update','update',$_SESSION['user']->guid,$plugin_project->guid);
} else {
	register_error(elgg_echo("plugins:uploadfailed"));
}

forward($plugin_project->getURL());
