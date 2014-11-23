<?php
/**
 * Sidebar box for project images
 */


$project = $vars['entity'];

$img_files = $project->getScreenshots();

if (!$img_files) {
	return;
}

elgg_load_css('smoothproducts');

echo '<div class="plugin-screenshots-wrapper clearfix">';
echo '<div class="sp-wrap">';
foreach ($img_files as $file) {
	$thumb = get_entity($file->thumbnail_guid);
	if (!$thumb) {
		continue;
	}

	$src = elgg_get_site_url() . "plugins/icon/{$file->getGUID()}/icon.jpg";
	$link = elgg_get_site_url() . "plugins/icon/{$file->getGUID()}/icon.jpg";

	echo "<a href=\"$link\"><img src=\"$src\" alt=\"$file->title\" title=\"$file->title\" /></a>";
}

echo "</div>";
echo '</div>';