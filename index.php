<?php
/**
 * List a developer's plugins
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

//set the title
if(page_owner() == $_SESSION['user']){
	$area2 = elgg_view_title($title = elgg_echo('plugins:yours'));
}else{
	$area2 = elgg_view_title($title = elgg_echo('pluginss'));
}

// Get objects
set_context('search');
$pop = get_input('pop');
if ($pop) {
	$area2 = list_entities_from_annotation_count("object", "plugin_project", "download", 10, 0, 0, false, true, false);
} else {
	$area2 .= list_entities("object","plugin_project",page_owner(),10);
}
set_context('pluginproject');
$area1 = plugins_get_filetype_cloud(page_owner());

$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);

// Finally draw the page
page_draw(sprintf(elgg_echo("plugins:user"),page_owner_entity()->name), $body);