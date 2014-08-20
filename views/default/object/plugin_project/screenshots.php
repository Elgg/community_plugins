<?php
/**
 * Sidebar box for project images
 */

elgg_load_js('lightbox');
elgg_load_css('lightbox');
//elgg_load_js('elgg.communityPlugins.PluginImages');

$project = $vars['entity'];

// ordering by guid does not guarantee the correct order
$img_files = $project->getScreenshots();

$thumbnails = '';
foreach ($img_files as $file) {
	$thumb = get_entity($file->thumbnail_guid);
	if (!$thumb) {
		continue;
	}

	$path_parts = pathinfo($file->getFilenameOnFilestore());
	$image_name = $path_parts['basename'];
	$link = "mod/community_plugins/image.php?&owner_guid={$file->owner_guid}&name={$image_name}";

	$path_parts = pathinfo($thumb->getFilenameOnFilestore());
	$thumb_name = $path_parts['basename'];

	$img = elgg_view('output/img', array(
		'src' => "mod/community_plugins/image.php?&owner_guid={$thumb->owner_guid}&name={$thumb_name}",
		'alt' => $file->title,
		'title' => $file->title,
		'width' => '60',
		'height' => '60',
	));

	$thumbnail = elgg_view('output/url', array(
		'href' => $link,
		'text' => $img,
		'rel' => 'plugins-gallery',
		'class' => 'elgg-plugin-screenshot elgg-lightbox',
	));

	$delete_link = '';
	if ($project->canEdit()) {
		$url = "/action/plugins/delete_project_image?project_guid={$project->getGUID()}&image_guid={$file->getGUID()}";

		$delete_link = elgg_view('output/confirmlink', array(
			'href' => $url,
			'text' => 'delete',
			'confirm' => elgg_echo("plugins:delete_project_image:confirm"),
			'is_action' => true,
			'style' => 'display: block;',
		));
	}

	$thumbnails .= "<li>{$thumbnail}{$delete_link}</li>";
}

echo "<ul class=\"elgg-gallery elgg-plugin-screenshots float-alt\">$thumbnails</ul>";
