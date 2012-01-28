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
		$list = list_entities('object', 'plugin_project', 0, 10, true, false, true);
	} else {
		$list = list_entities_from_metadata("plugincat", $category, "object", "plugin_project", 0, 10, true, false, true);
	}
}
elgg_set_context('plugins');

$sidebar = elgg_view('plugins/filters', array(
	'categories' => $CONFIG->plugincats,
	'versions' => $CONFIG->elgg_versions,
	'licences' => $CONFIG->gpllicenses
));

$main = elgg_view('plugins/search/main', array('area1' => $list));

$body = elgg_view_layout('plugins_layout', $main, $sidebar);

page_draw($title, $body);
