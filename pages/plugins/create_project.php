<?php
/**
 * Create a new plugin project
 */

gatekeeper();

$container_guid = elgg_get_page_owner_guid();

$title = elgg_echo('plugins:upload');

$content = elgg_view_title($title);
$content .= elgg_view_form("plugins/create_project", array(
	'enctype' => 'multipart/form-data'
), array(
	'container_guid' => $container_guid,
));
$body = elgg_view_layout('two_column_left_sidebar', array(
	'area1' => '', 
	'area2' => $content,
));
	
echo elgg_view_page($title, $body);
