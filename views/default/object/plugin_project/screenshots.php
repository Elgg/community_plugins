<?php
/**
 * Sidebar box for project images
 */

$project = $vars['entity'];

$img_files = $project->getScreenshots();

if (!$img_files) {
	return;
}

$thumbs = '';
foreach ($img_files as $file) {
	$thumb = get_entity($file->thumbnail_guid);
	if (!$thumb) {
		continue;
	}

	$src = elgg_normalize_url("plugins/icon/{$file->guid}/icon.jpg");
	$link = elgg_normalize_url("plugins/icon/{$file->guid}/icon.jpg");

	$thumbs .= elgg_view('output/url', [
		'text' => elgg_view('output/img', [
			'src' => $src,
			'alt' => $file->title,
		]),
		'href' => $link,
		'rel' => 'plugin-screenshots-gallery',
		'class' => 'elgg-photo',
	]);
}

if (!$thumbs) {
	return;
}

echo elgg_format_element('div', [
	'class' => 'plugin-screenshots-wrapper',
], $thumbs);
