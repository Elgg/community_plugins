<?php
/**
 * View a plugin project or release
 */

$project = get_entity((int) get_input('guid'));

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
		
		$release = $project->getRecommendedRelease();
		if ($release) {
			register_error(elgg_echo('plugins:forward:recommended_release'));
			forward($release->getURL());
		}
		
		forward();
	}
} else {
	register_error(elgg_echo('plugins:error:unrecognized_plugin'));
	forward('plugins');
}

elgg_set_page_owner_guid($project->getOwnerGUID());

// grab the entity and sidebar views
$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));
$content = elgg_view_entity($project, array(
	'full_view' => TRUE,
	'release' => $release,
));

$body = elgg_view_layout("one_sidebar", array(
	'sidebar' => $sidebar, 
	'content' => $content,
));

echo elgg_view_page("$project->title, version $release->version", $body);
