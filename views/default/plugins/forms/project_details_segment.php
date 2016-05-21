<?php

/**
 * Project details to be used in a form body.
 */
$sticky_values = elgg_get_sticky_values('community_plugins');

$project = elgg_extract('project', $vars);

// set defaults for new or editing
if ($project instanceof PluginProject) {
	$project = $vars['project'];
	$title = $project->title;
	$summary = $project->summary;
	$description = $project->description;
	$homepage = $project->homepage;
	$plugin_type = $project->plugin_type;
	$plugincat = $project->plugincat;
	$license = $project->license;
	$donate = $project->donate;
	$tags = $project->tags;
	$access_id = $project->access_id;
	$repo = $project->repo;

	$msglink = elgg_view('output/url', array(
		'text' => elgg_echo('plugins:link:here'),
		'href' => elgg_get_site_url() . "plugins/new/release/{$project->getGUID()}",
		'is_trusted' => true
	));
	$msg = elgg_echo('plugins:edit:helptext', array($project->title, $msglink));
} else {
	$title = $description = $homepage = $plugin_type = '';
	$license = $donate = $tags = '';

	$plugincat = 'uncategorized';
	$access_id = ACCESS_PUBLIC;
	$username = elgg_get_logged_in_user_entity()->username;

	$msglink = elgg_view('output/url', array(
		'text' => elgg_echo('plugins:link:here'),
		'href' => elgg_get_site_url() . "plugins/developer/{$username}",
		'is_trusted' => true
	));
	$msg = elgg_echo('plugins:add:helptext', array($msglink));
}

echo elgg_format_element('p', [], $msg);

$fields = [
	'title' => [
		'value' => $sticky_values['title'] ? $sticky_values['title'] : $title,
		'label' => elgg_echo('plugins:edit:label:name'),
	],
	'summary' => [
		'value' => $sticky_values['summary'] ? $sticky_values['summary'] : $summary,
		'maxlength' => 250,
		'label' => elgg_echo('plugins:edit:label:project_summary'),
		'help' => elgg_echo('plugins:edit:help:project_summary'),
	],
	'description' => [
		'type' => 'longtext',
		'value' => $sticky_values['description'] ? $sticky_values['description'] : $description,
		'label' => elgg_echo('plugins:edit:label:description'),
		'help' => elgg_echo('plugins:edit:help:description', [
			elgg_view('output/url', array(
				'text' => elgg_echo('policy'),
				'href' => 'http://community.elgg.org/terms#plugins'
			)),
		]),
	],
	'license' => [
		'type' => 'dropdown',
		'value' => $sticky_values['license'] ? $sticky_values['license'] : $license,
		'options_values' => elgg_get_config('gpllicenses'),
		'label' => elgg_echo('license'),
		'help' => elgg_format_element('a', [
			'href' => 'http://www.gnu.org/philosophy/license-list.html#GPLCompatibleLicenses',
			'target' => '_blank',
				], elgg_echo('license:blurb')),
	],
	'plugin_type' => [
		'type' => 'dropdown',
		'value' => $sticky_values['plugin_type'] ? $sticky_values['plugin_type'] : $plugin_type,
		'options_values' => array(
			'plugin' => elgg_echo('plugins:plugin'),
			'theme' => elgg_echo('plugins:theme'),
			'languagepack' => elgg_echo('plugins:languagepack'),
		),
		'label' => elgg_echo('plugins:edit:label:plugin_type'),
	],
	'plugincat' => [
		'type' => 'dropdown',
		'value' => $sticky_values['plugincat'] ? $sticky_values['plugincat'] : $plugincat,
		'options_values' => elgg_get_config('plugincats'),
		'id' => 'category',
		'label' => elgg_echo('plugins:category'),
	],
	'homepage' => [
		'value' => $sticky_values['homepage'] ? $sticky_values['homepage'] : $homepage,
		'label' => elgg_echo('plugins:edit:label:project_homepage'),
	],
	'repo' => [
		'value' => $sticky_values['repo'] ? $sticky_values['repo'] : $repo,
		'label' => elgg_echo('plugins:repo'),
	],
	'donate' => [
		'value' => $sticky_values['donate'] ? $sticky_values['donate'] : $donate,
		'label' => elgg_echo('plugins:edit:label:donate'),
		'help' => elgg_echo('plugins:edit:help:donate'),
	],
	'tags' => [
		'value' => $sticky_values['tags'] ? $sticky_values['tags'] : $tags,
		'label' => elgg_echo('tags'),
		'help' => elgg_echo('plugins:edit:help:tags'),
	],
	'project_access_id' => [
		'type' => 'access',
		'value' => $sticky_values['project_access_id'] ? $sticky_values['project_access_id'] : $access_id,
		'label' => elgg_echo('access'),
		'help' => elgg_echo('plugins:edit:help:access'),
	],
];

foreach ($fields as $name => $options) {
	$options['name'] = $name;
	$options['field_class'] = 'elgg-input-wrapper';
	$type = elgg_extract('type', $options, 'text');
	unset($options['type']);
	echo elgg_view_input($type, $options);
}

$images = elgg_view('plugins/forms/project_images_segment', $vars);
echo elgg_view_module('aside', elgg_echo('plugins:edit:label:project_images'), $images);
