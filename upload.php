<?php
/**
 * Create a new plugin project
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

// Render the file upload page
$container_guid = page_owner();
$area2 = elgg_view_title($title = elgg_echo('plugins:upload'));
$area2 .= elgg_view("plugins/upload", array('container_guid' => $container_guid));
$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	
page_draw(elgg_echo("plugins:upload"), $body);