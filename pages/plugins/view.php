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
	if (!isset($release)) {
		register_error(elgg_echo('plugins:error:invalid_release'));
		forward($project->getUrl());
	}
} else {
	$release = $project->getRecommendedRelease();
}

elgg_set_page_owner_guid($project->getOwnerGUID());

// grab the entity and sidebar views
$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));
$content = elgg_view_entity($project, array(
	'full_view' => TRUE,
	'release' => $release,
));

$title = $project->title;
if ($release && $release->elgg_version) {
	if (is_array($release->elgg_version)) {
		$versions = implode('/', array_reverse($release->elgg_version));
	} else {
		$versions = $release->elgg_version;
	}

	$title = $project->title;
}

$body = elgg_view_layout("one_sidebar", array(
	'title' => $title,
	'sidebar' => $sidebar, 
	'content' => $content,
));


echo elgg_view_page($project->title . ($release ? ", version $release->version" : ""), $body);
