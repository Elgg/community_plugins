<?php
/**
 * Plugin release
 *
 */

$release = elgg_extract('entity', $vars);
if (!$release instanceof PluginRelease) {
	return;
}

$notes = $release->release_notes;

if (!empty($notes)) {
	echo elgg_format_element('h3', [], elgg_echo('plugins:edit:label:release_notes'));
	echo elgg_view('output/longtext', [
		'value' => $notes,
	]);
}

if ($release->comments == 'yes') {
	echo elgg_view_comments($release);
}
