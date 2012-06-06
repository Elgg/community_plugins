<?php


global $CONFIG;

// get filter
$category = get_input('category');
$category_label = $CONFIG->plugincats[$category];

$title = sprintf(elgg_echo('plugins:category:title'), $category_label);

// Get objects
elgg_set_context('search');
if ($category) {
	if ($category == 'all') {
		$title = sprintf(elgg_echo('plugins:category:title'), elgg_echo('plugins:cat:all'));
		$list = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'plugin_project',
		));
	} else {
		$list = elgg_list_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'plugin_project',
			'metadata_name' => "plugincat",
			'metadata_value' => $category,
		));
	}
}
elgg_set_context('plugins');

$sidebar = elgg_view('plugins/filters', array(
	'categories' => $CONFIG->plugincats,
	'versions' => $CONFIG->elgg_versions,
	'licences' => $CONFIG->gpllicenses
));

$main = elgg_view('plugins/search/main', array('area1' => $list));

$body = elgg_view_layout('one_sidebar', array(
	'content' => $main, 
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
