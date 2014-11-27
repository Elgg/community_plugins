<?php

/**
 * View a plugin project or release
 */
$project = get_entity(get_input('plugin'));
if (!$project instanceof PluginProject) {
	header('Status: 404 Not Found');
	$body = elgg_view("plugins/notfound");
	$title = elgg_echo("plugins:notfound");
	echo elgg_view_page($title, $body);
	exit;
}

$version = get_input('version');
if ($version) {
	$release = $project->getReleaseFromVersion($version);
}

if (!$release) {
	register_error(elgg_echo('plugins:error:invalid_release'));
	forward($project->getUrl());
}

elgg_set_page_owner_guid($project->getOwnerGUID());

// set breadcrumbs
elgg_push_breadcrumb(elgg_echo('plugins'), 'plugins');
elgg_push_breadcrumb($project->title, $project->getURL());
elgg_push_breadcrumb($release->version);


if ($release->canEdit()) {
	elgg_register_menu_item('title', array(
		'name' => 'edit',
		'href' => "/plugins/edit/release/" . $release->guid,
		'text' => elgg_echo('edit'),
		'link_class' => 'elgg-button elgg-button-submit',
		'encode_text' => TRUE,
	));
}

elgg_register_menu_item('title', array(
	'name' => 'download',
	'href' => "/plugins/download/" . $release->guid,
	'text' => elgg_echo('plugins:download:version', array($release->version)),
	'link_class' => 'elgg-button elgg-button-submit',
	'encode_text' => TRUE,
));

elgg_register_menu_item('title', array(
	'name' => 'project_page',
	'href' => $project->getURL(),
	'text' => elgg_echo('plugins:project:page:view'),
	'link_class' => 'elgg-button elgg-button-submit',
	'encode_text' => TRUE,
));


// grab the entity and sidebar views
$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));
$content = elgg_view_entity($release, array(
	'full_view' => TRUE
		));

$title = $project->title . ' v' . $release->version;

$body = elgg_view_layout("one_sidebar", array(
	'title' => $title,
	'sidebar' => $sidebar,
	'content' => $content,
		));


echo elgg_view_page($project->title, $body);
