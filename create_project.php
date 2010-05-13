<?php
/**
 * Create a new plugin project
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

$container_guid = page_owner();

$title = elgg_echo('plugins:upload');

$area2 = elgg_view_title($title);
$area2 .= elgg_view("plugins/forms/create_project", array('container_guid' => $container_guid));
$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	
page_draw($title, $body);