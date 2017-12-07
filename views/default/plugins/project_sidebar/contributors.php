<?php

$project = elgg_extract('entity', $vars);
if (!$project instanceof PluginProject) {
	return;
}

$contributors = elgg_get_entities_from_relationship([
	'type' => 'user',
	'relationship' => PLUGINS_CONTRIBUTOR_RELATIONSHIP,
	'relationship_guid' => $project->guid,
	'inverse_relationship' => true,
	'limit' => false,
	'order_by' => 'r.time_created ASC',
	'batch' => true,
]);

/* @var $contributor ElggUser */
foreach ($contributors as $contributor) {
	$icon = elgg_view_entity_icon($contributor, 'tiny');
	$link = elgg_view('output/url', [
		'text' => $contributor->name,
		'href' => $contributor->getURL(),
		'is_trusted' => true,
	]);

	$delete = '';
	if ($project->canEdit()) {
		$delete = elgg_view('output/url', [
			'text' => elgg_view_icon('delete'),
			'href' => elgg_http_add_url_query_elements('action/plugins/delete_contributor', [
				'project' => $project->guid,
				'user' => $contributor->guid,
			]),
			'confirm' => elgg_echo('deleteconfirm'),
		]);
	}

	echo elgg_view_image_block($icon, $link, ['image_alt' => $delete]);
}
