<?php
/**
 * List a developer's plugins
 */

namespace Elgg\CommunityPlugins;

$type = get_input('type', '');
//$tag = get_input('tag', '');

add_type_menu(elgg_get_page_owner_guid());

//set the title
$types_string = elgg_echo("plugins:types:$type");
if (elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()){
	$title = sprintf(elgg_echo('plugins:yours'), $types_string);;
} else {
	$title = sprintf(elgg_echo("plugins:user"), elgg_get_page_owner_entity()->name, $types_string);
}

//$pop = get_input('pop');
//$area2 = list_entities_from_annotation_count("object", "plugin_project", "download", 10, 0, 0, false, true, false);

// list plugins
elgg_set_context('search');
$params = array(
	'types' => 'object',
	'subtypes' => 'plugin_project',
	'owner_guid' => elgg_get_page_owner_guid(),
	'limit' => 10,
	'full_view' => FALSE,
);
if ($type) {
	$params['metadata_name'] = 'plugin_type';
	$params['metadata_value'] = $type;
	$content .= elgg_list_entities_from_metadata($params);
} else {
	$content .= elgg_list_entities($params);
}

$body = elgg_view_layout('one_sidebar', array(
    'title' => $title,
	'sidebar' => '',
	'content' => $content,
));

echo elgg_view_page($title, $body);
