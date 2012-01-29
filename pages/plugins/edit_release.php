<?php
/**
 * Edit plugin release
 */

gatekeeper();

$release_guid = (int) get_input('release_guid');
$release = get_entity($release_guid);
if (!$release || !$release->canEdit()) {
	register_error('Unknown project or insufficient access.');
	forward();
}

$project = get_entity($release->container_guid);

elgg_set_page_owner_guid($project->owner_guid);

$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:edit:release');

$content = elgg_view_title($title);
$content .= elgg_view_form("plugins/save_release", array(
	'enctype' => 'multipart/form-data',
), array(
	'release' => $release,
));

$body = elgg_view_layout('sidebar_boxes', array(
	'area1' => $sidebar, 
	'area2' => $content,
));
echo elgg_view_page($title, $body);
