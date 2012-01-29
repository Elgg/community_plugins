<?php
/**
 * View a plugin project or release
 */

// for backward compatibility if called directly
elgg_set_context('plugins');


$project = get_entity((int) get_input('guid'));

// Backwards compatibility. Do not remove.
if ($project instanceof PluginRelease && $project->getURL() != current_page_url()) {
	system_message('Please update your bookmark or report this link to the site owner as this page has moved.');
	header("Location: {$project->getURL()}", true, 301);
	exit;
}

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
		register_error("We could not find the release you specified.");
		
		$release = $project->getRecommendedRelease();
		if ($release) {
			register_error("Forwarded to recommended release.");
			forward($release->getURL());
		}
		
		forward();
	}
} else {
	$release = $project->getRecommendedRelease();
	
	if (!$release) {
		$release = $project->getLatestRelease();
	}
	
	// If there's no release here, there are no releases at all, which doesn't make much sense...
}

// Always forward to the new address
if ($release && $release->getURL() != current_page_url()) {
	forward($release->getURL());
	exit;
}

elgg_set_page_owner_guid($project->getOwnerGUID());

// grab the entity and sidebar views
$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));
$content = elgg_view_entity($project, array(
	'full_view' => TRUE,
	'release' => $release,
));

$body = elgg_view_layout("sidebar_boxes", array(
	'area1' => $sidebar, 
	'area2' => $content,
));

echo elgg_view_page("$project->title, version $release->version", $body);
