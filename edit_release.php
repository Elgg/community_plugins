<?php
/**
 * Edit plugin release
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

$release_guid = (int) get_input('release_guid');
if (($release = get_entity($release_guid)) && $release->canEdit()) {
	$project = get_entity($release->container_guid);
	$area1 = elgg_view('plugins/plugin_sidebar', array('entity' => $project));

	$area2 = elgg_view_title($title = elgg_echo('plugins:edit'));
	$area2 .= elgg_view("plugins/edit_release", array('release' => $release));

	$body = elgg_view_layout('sidebar_boxes', $area1, $area2);
	page_draw(elgg_echo("plugins:upload"), $body);
} else {
	register_error('Unknown project or insufficient access.');
	forward();
}