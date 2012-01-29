<?php

$release = $vars['entity'];
$label = $vars['label'];

echo '<div class="plugins_release_links">';

if ($label) {
	echo "$label: ";
}

$time = elgg_view_friendly_time($release->time_created);
echo elgg_view('output/url', array(
	'href' => $release->getURL(),
	'text' => "$release->version ($time)",
));

if ($release->canEdit()) {
	$delete = elgg_view('output/confirmlink', array(
		'href' => "/action/plugins/delete_release?release_guid={$release->guid}",
		'text' => elgg_echo('delete'),
		'confirm' => elgg_echo("plugins:delete_release:confirm"),
	));
	echo " [$delete]";

	$edit = elgg_view('output/url', array(
		'href' => "/plugins/edit/release/{$release->guid}",
		'text' => elgg_echo('edit'),
	));
	echo " [$edit]";
}

echo '</div>';