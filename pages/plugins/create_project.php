<?php
/**
 * Create a new plugin project
 */

gatekeeper();

$title = elgg_echo('plugins:upload');

$content = elgg_view_title($title);

$form_vars = array('enctype' => 'multipart/form-data');
$body_vars = plugins_perform_form_vars();
$content .= elgg_view_form("plugins/create_project", $form_vars, $body_vars);
$body = elgg_view_layout('one_sidebar', array(
	'sidebar' => '', 
	'content' => $content,
));
	
echo elgg_view_page($title, $body);
