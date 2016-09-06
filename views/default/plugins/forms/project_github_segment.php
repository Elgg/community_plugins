<?php

$sticky_values = elgg_get_sticky_values('community_plugins');

elgg_require_js('plugins/forms/project_github_segment');

$project = elgg_extract('project', $vars);

if (!$project) {
	$github_owner = '';
	$github_repo = '';
	$github_access = ACCESS_PUBLIC;
	$github_comments = 'yes';
} else {
	$github_owner = $project->github_owner;
	$github_repo = $project->github_repo;
	$github_access = $project->github_access_id;
	$github_comments = $project->github_comments;
}

echo elgg_format_element('p', [], elgg_echo('plugins:edit:help:project_github'));

echo elgg_view_input('text', [
	'name' => 'github_owner',
	'value' => elgg_extract('github_owner', $sticky_values, $github_owner),
	'label' => elgg_echo('plugins:edit:label:github_owner'),
]);

echo elgg_view_input('text', [
	'name' => 'github_repo',
	'value' => elgg_extract('github_repo', $sticky_values, $github_repo),
	'label' => elgg_echo('plugins:edit:label:github_repo'),
]);

echo elgg_view_input('access', [
	'name' => 'github_access_id',
	'label' => elgg_echo('access'),
	'value' => elgg_extract('github_access_id', $sticky_values, $github_access),
	'help' => elgg_echo('plugins:edit:help:github_access'),
]);

echo elgg_view_input('radio', [
	'name' => 'github_comments',
	'value' => elgg_extract('github_comments', $sticky_values, $github_comments),
	'options' => array(
		elgg_echo('plugins:yes') => 'yes',
		elgg_echo('plugins:no') => 'no',
	),
	'label' => elgg_echo('plugins:edit:label:comments'),
	'help' => elgg_echo('plugins:edit:help:github_comments'),
]);

if (!$project || !$project->github_secret) {
	echo elgg_format_element('div', ['class' => 'plugins-github-instructions'], elgg_echo('plugins:github:setup_instructions'));
}

if ($project) {
	if ($project->github_secret) {
		$attrs = [
			'payload_url' => elgg_normalize_url("/plugins/gh/$project->guid"),
			'content_type' => 'application/json',
			'secret' => $project->github_secret,
		];
		$attrs_table = '';
		foreach ($attrs as $key => $val) {
			$attrs_table .= elgg_format_element('span', [], elgg_echo("plugins:github:$key")) . ': ' . elgg_format_element('b', [], $val) . '<br />';
		}
		echo elgg_format_element('div', ['class' => 'plugins-github-instructions'], elgg_echo('plugins:github:auto_release_instructions', [$attrs_table]));
	}
} else {
	echo elgg_format_element('button', [
		'class' => 'elgg-button elgg-button-action plugins-github-releases-button',
		'disabled' => !($github_owner && $github_repo),
			], elgg_echo('plugins:edit:label:fetch_releases'));

	echo elgg_format_element('div', [
		'class' => 'plugins-github-releases-input-container',
	]); // Used for fetched releases input
}
