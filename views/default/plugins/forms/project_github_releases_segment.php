<?php

$releases = elgg_extract('releases', $vars);

if (!is_array($releases)) {
	return;
}

$options = [];

foreach ($releases as $release) {

	$assets = $release['assets'];
	if (empty($assets)) {
		continue;
	}
	foreach ($assets as $asset) {
		if ($asset['content_type'] !== 'application/zip') {
			continue;
		}
	}

	$id = $release['id'];
	$name = $release['name'];
	$tag_name = $release['tag_name'];
	$href = $release['url'];

	$link = elgg_view('output/url', [
		'text' => $tag_name,
		'href' => $href,
		'target' => '_blank',
	]);
	$options[$id] = "$name [$link]";
}

if (empty($options)) {
	return;
}

$docs = elgg_view('output/url', [
	'text' => 'elgg_release',
	'href' => 'http://learn.elgg.org/en/2.0/guides/plugins/dependencies.html?highlight=require#elgg-release',
	'target' => '_blank',
		]);

echo elgg_format_element('p', [], elgg_echo('plugins:edit:label:github_instructions', [$docs]));

echo elgg_view_input('checkboxes', [
	'name' => 'github_releases',
	'class' => 'plugins-github-releases-input',
	'options' => array_flip($options),
	'label' => elgg_echo('plugins:edit:label:github_release'),
	'help' => elgg_echo('plugins:edit:help:github_release'),
]);

$extras = ''; // shown only when release is selected
echo elgg_format_element('div', [
	'class' => 'plugins-github-releases-meta hidden',
		], $extras);

