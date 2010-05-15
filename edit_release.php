<?php
/**
 * Edit plugin release
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

$release_guid = (int) get_input('release_guid');
$release = get_entity($release_guid);
if (!$release || !$release->canEdit()) {
	register_error('Unknown project or insufficient access.');
	forward();
}

$project = get_entity($release->container_guid);
$area1 = elgg_view('plugins/plugin_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:edit:release');

$area2 = elgg_view_title($title);
$area2 .= elgg_view("plugins/forms/edit_release", array('release' => $release));

$body = elgg_view_layout('sidebar_boxes', $area1, $area2);
page_draw($title, $body);
