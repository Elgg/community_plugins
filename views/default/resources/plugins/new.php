<?php
/**
 * Create a new plugin project
 */

gatekeeper();

elgg_push_breadcrumb(elgg_echo('plugins'), 'plugins');
elgg_push_breadcrumb(elgg_echo('plugins:new:plugin'));

$container_guid = elgg_get_logged_in_user_guid();

$title = elgg_echo('plugins:upload');

$content = elgg_view_form("plugins/create_project", array(
	'enctype' => 'multipart/form-data'
), array(
	'container_guid' => $container_guid,
));
$body = elgg_view_layout('one_sidebar', array(
    'title' => $title,
	'sidebar' => '', 
	'content' => $content,
));
	
echo elgg_view_page($title, $body);
