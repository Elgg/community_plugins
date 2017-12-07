<?php
/**
 * Release details for use inside a form body.
 */

elgg_require_js('elgg/community_plugins/releases_edit');

$sticky_values = elgg_get_sticky_values('community_plugins');

$project = elgg_extract('project', $vars);
if (!$project instanceof PluginProject) {
	$project = null;
}

$release = elgg_extract('release', $vars);
// default vars to use if editing or new
if ($release instanceof PluginRelease) {
	$elgg_version = $release->elgg_version;
	$version = $release->version;
	$release_notes = $release->release_notes;
	$comments = $release->comments;

	$recommended = $release->recommended;
	$access_id = $release->access_id;
} else {
	$project = $release = $elgg_version = $version = $release_notes = NULL;

	$comments = 'yes';
	$recommended = array();
	$access_id = ($project) ? $project->access_id : ACCESS_PUBLIC;
}

echo elgg_view('output/longtext', array(
	'value' => elgg_echo('plugins:edit:help:release')
));

if (empty($release)) {
	echo elgg_view_field([
		'#type' => 'file',
		'#label' => elgg_echo('plugins:file'),
		'#help' => elgg_echo('plugins:edit:help:file'),
		'name' => 'upload',
		'required' => true,
	]);
}

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('plugins:edit:label:release_version'),
	'#help' => elgg_echo('plugins:edit:help:file'),
	'name' => 'version',
	'value' => elgg_extract('version', $sticky_values, $version),
	'required' => true,
	'style' => 'width: 5em',
]);

$release_link = elgg_view('output/url', [
	'text' => elgg_echo('policy'),
	'href' => "https://elgg.org/expages/read/Terms/#plugins",
	'is_trusted' => true,
]);

echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('plugins:edit:label:release_notes'),
	'#help' => elgg_echo('plugins:edit:help:release_notes', [$release_link]),
	'name' => 'release_notes',
	'value' => elgg_extract('release_notes', $sticky_values, $release_notes),
]);

echo elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#type' => 'checkboxes',
			'#label' => elgg_echo('plugins:edit:label:elgg_version') . ' *',
			'#help' => elgg_echo('plugins:edit:help:elgg_version'),
			'name' => 'elgg_version',
			'value' => elgg_extract('elgg_version', $sticky_values, $elgg_version),
			'options' => elgg_get_config('elgg_versions'),
			'default' => false,
			'data-release' => $release ? $release->guid : 0
		],
		[
			'#type' => 'checkboxes',
			'#label' => elgg_echo('plugins:edit:label:recommended'),
			'#help' => elgg_echo('plugins:edit:help:recommended'),
			'name' => 'recommended',
			'value' => elgg_extract('recommended', $sticky_values, $recommended),
			'options' => elgg_get_config('elgg_versions'),
			'default' => false,
		]
	],
]);

echo elgg_view_field([
	'#type' => 'radio',
	'#label' => elgg_echo('plugins:edit:label:comments'),
	'name' => 'comments',
	'value' => elgg_extract('comments', $sticky_values, $comments),
	'options' => [
		elgg_echo('plugins:yes') => 'yes',
		elgg_echo('plugins:no') => 'no',
	],
]);

echo elgg_view_field([
	'#type' => 'access',
	'#label' => elgg_echo('access'),
	'#help' => elgg_echo('plugins:edit:help:access'),
	'name' => 'release_access_id',
	'value' => elgg_extract('release_access_id', $sticky_values, $access_id),
	'entity' => $release,
	'entity_type' => 'object',
	'entity_subtype' => PluginRelease::SUBTYPE,
]);
