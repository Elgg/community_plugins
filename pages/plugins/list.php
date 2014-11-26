<?php

// Get search-specific settings
$serialized_settings = elgg_get_plugin_setting('search-settings', 'community_plugins');
$settings = unserialize($serialized_settings);
if (!is_array($settings)) {
	$settings = array();
}

$offset = get_input('offset', 0);
$limit = get_input('limit', 10);

$options = array(
	'type' => 'object',
	'subtype' => 'plugin_project'
);

$list_type = get_input('type');
$dbprefix = elgg_get_config('dbprefix');

switch ($list_type) {
	case 'recommended':
		$digg_id = add_metastring('plugin_digg', true);
		$options['selects'] = array("count(a.entity_guid) as recommendations");
		$options['joins'][] = "LEFT JOIN {$dbprefix}annotations a on (e.guid = a.entity_guid AND a.name_id = $digg_id)";
		$group_bys = array('e.guid', 'a.entity_guid');
		$options['group_by'] = implode(',', $group_bys);
		$options['order_by'] = "recommendations DESC";
		break;
	case 'popular':
		$options['selects'] = array("a.downloads");
		$options['joins'][] = "LEFT JOIN {$dbprefix}plugin_downloads a on (e.guid = a.guid)";
		$group_bys = array('e.guid', 'a.guid');
		$options['group_by'] = implode(',', $group_bys);
		$options['order_by'] = "a.downloads DESC";
		break;
	case 'newest':
	default:
		$options['order_by'] = 'e.last_action DESC';
		break;
}

// Get objects
elgg_set_context('search');
$options['full_view'] = false;
$list = elgg_list_entities_from_metadata($options);
$options['count'] = true;
$count = elgg_get_entities_from_metadata($options);
elgg_set_context('plugins');

$title = elgg_echo('plugins:search:title');

// Add sidebar filter
$sidebar = elgg_view('plugins/filters', array(
	'categories' => elgg_get_config('plugincats'),
	'versions' => elgg_get_config('elgg_versions'),
	'licences' => elgg_get_config('gpllicenses'),
	'current_values' => $filters,
	'settings' => $settings,
		));

// Add info block on search results to the main area
if ($count) {
	$first_index = $offset + 1;
	$last_index = min(array($offset + $limit, $count));
	$heading = elgg_view_title(sprintf(elgg_echo('plugins:search:results'), $count, $first_index, $last_index));
} else {
	$heading = elgg_view_title(elgg_echo('plugins:search:noresults'));
	$main = elgg_echo('plugins:search:noresults:info');
}

// Add the list of plugins to the main area
$main .= elgg_view('plugins/search/main', array('area1' => $list));

$body = elgg_view_layout('one_sidebar', array(
	'title' => $heading,
	'content' => $main,
	'sidebar' => $sidebar,
		));

echo elgg_view_page($title, $body);
