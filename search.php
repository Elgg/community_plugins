<?php
/**
 * Category listing (not search - search goes against the search mod)
 * Must keep the confusing name because previous version bypassed the
 * page handler and hit this script directly.
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

global $CONFIG;

// get filter
$category = get_input('category');
$category_label = $CONFIG->plugincats[$category];

$title = sprintf(elgg_echo('plugins:category:title'), $category_label);

// Get objects
set_context('search');
if ($category) {
	if ($category == 'all') {
		$list = list_entities('object', 'plugin_project', 0, 10, true, false, true);
	} else {
		$list = list_entities_from_metadata("plugincat", $category, "object", "plugin_project", 0, 10, true, false, true);
	}
}
set_context('plugins');

$sidebar = elgg_view('plugins/search/sidebar');

$main = elgg_view('plugins/search/main', array('area1' => $list));

$body = elgg_view_layout('plugins_layout', $main, $sidebar);

page_draw($title, $body);
