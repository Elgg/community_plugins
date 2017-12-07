<?php

$release = elgg_extract('entity', $vars);
if (!$release instanceof PluginRelease) {
	return;
}

$label = elgg_extract('label', $vars);

echo '<div class="plugins_release_links">';

if ($label) {
	echo "$label: ";
}

$time = elgg_view_friendly_time($release->time_created);
echo elgg_view('output/url', [
	'href' => $release->getURL(),
	'text' => "$release->version ($time)",
	'is_trusted' => true,
]);

if ($release->canDelete())
	$delete = elgg_view('output/url', [
		'href' => elgg_http_add_url_query_elements('/action/plugins/delete_release', [
			'release_guid' = => $release->guid,
		]),
		'text' => elgg_echo('delete'),
		'confirm' => elgg_echo("plugins:delete_release:confirm"),
	));
	echo " [$delete]";
}

if ($release->canEdit()) {
	$edit = elgg_view('output/url', [
		'href' => "/plugins/edit/release/{$release->guid}",
		'text' => elgg_echo('edit'),
	]);
	echo " [$edit]";
}

echo '</div>';
