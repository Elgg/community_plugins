<?php

$project = elgg_extract('entity', $vars);
if (!$project instanceof PluginProject) {
	return;
}

elgg_require_js('elgg/community_plugins/plugin_page');

/* @var PluginRelease $release */
$release = elgg_extract('release', $vars);

// get required variables
$project_owner = $project->getOwnerEntity();

$updated = elgg_view_friendly_time($project->getLatestRelease()->time_created);

if ($project->canEdit()) {
	elgg_register_menu_item('title', [
		'name' => 'edit',
		'link_class' => 'elgg-button elgg-button-action',
		'href' => "plugins/edit/project/{$project->guid}",
		'text' => elgg_echo('edit'),
	]);
}

if (elgg_is_logged_in() && !$project->isDugg()) {
	elgg_register_menu_item('title', [
		'name' => 'recommend',
		'link_class' => 'elgg-button elgg-button-action',
		'href' => "/action/plugins/recommend?guid={$project->guid}",
		'is_action' => true,
		'text' => elgg_echo('Recommend'),
	]);
}

echo elgg_view('object/plugin_project/warning', ['entity' => $project]);

$screenshots = elgg_view('object/plugin_project/screenshots', ['entity' => $project]);

$stable_downloads = elgg_view('object/plugin_project/release_table', [
	'entity' => $project,
	'stable' => true,
]);

echo elgg_format_element('h4', [], elgg_view('output/text', ['value' => $project->summary]));

$image = elgg_view_entity_icon($project_owner, 'tiny');
$author_link = elgg_view('output/url', [
	'href' => "/plugins/developer/{$project_owner->username}",
	'text' => $project_owner->name,
	'encode_text' => TRUE,
]);
$tags = elgg_view('output/tags', ['value' => $project->tags]);

$by_author = elgg_echo('plugins:author:byline', [$author_link]);
$last_updated = elgg_echo('plugins:last:updated', [$updated]);

$body = <<<DETAILS
	<div class="elgg-subtext">$by_author</div>
	<div class="elgg-subtext">$last_updated</div>
DETAILS;

echo elgg_view_image_block($image, $body);

echo $screenshots;

echo $stable_downloads;

echo elgg_view('output/longtext', [
	'value' => $project->description,
]);
