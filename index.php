<?php
/**
 * List a developer's plugins
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$type = get_input('type', '');
//$tag = get_input('tag', '');

plugins_add_type_menu(page_owner());

//set the title
$types_string = elgg_echo("plugins:types:$type");
if (page_owner() == get_loggedin_userid()){
	$title = sprintf(elgg_echo('plugins:yours'), $types_string);;
} else {
	$title = sprintf(elgg_echo("plugins:user"), page_owner_entity()->name, $types_string);
}

$area2 = elgg_view_title($title);

//$pop = get_input('pop');
//$area2 = list_entities_from_annotation_count("object", "plugin_project", "download", 10, 0, 0, false, true, false);

// list plugins
set_context('search');
if ($type) {
	$area2 .= list_entities_from_metadata('plugin_type', $type, 'object', 'plugin_project', page_owner(), 10, FALSE, FALSE);
} else {
	$area2 .= list_entities("object", "plugin_project", page_owner(), 10, FALSE);
}

$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

page_draw($title, $body);