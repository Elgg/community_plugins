<?php
/**
 * View a list of entities
 *
 * @package Elgg
 *
 */

$context = $vars['context'];
$offset = $vars['offset'];
$entities = $vars['entities'];
$limit = $vars['limit'];
$count = $vars['count'];
$baseurl = $vars['baseurl'];
$context = $vars['context'];
$viewtype = $vars['viewtype'];
$pagination = $vars['pagination'];
$fullview = $vars['fullview'];

$sort_fields = array('title', 'author', 'downloads', 'recommendations', 'created', 'updated');
$sort = get_input('sort', 'created');
$direction = get_input('direction', 'desc');


// Get search-specific settings
$serialized_settings = get_plugin_setting('search-settings', 'community_plugins');
$settings = unserialize($serialized_settings);
if (!is_array($settings)) {
	$settings = array();
}

$html = "";
$nav = "";

if (isset($vars['viewtypetoggle'])) {
    $viewtypetoggle = $vars['viewtypetoggle'];
} else {
    $viewtypetoggle = true;
}

if ($context == "search" && $count > 0 && $viewtypetoggle) {
    $nav .= elgg_view('navigation/viewtype', array(
        'baseurl' => $baseurl,
        'offset' => $offset,
        'count' => $count,
        'viewtype' => $viewtype,
    ));
}

if ($pagination) {
    $nav .= elgg_view('navigation/pagination',array(
        'baseurl' => $baseurl,
        'offset' => $offset,
        'count' => $count,
        'limit' => $limit,
    ));
}

$html .= $nav;

if ($count && isset($settings['sort']) && $settings['sort'] == 'enabled') {
	$html .= elgg_view('navigation/sort',array(
	        	'baseurl' => $baseurl,
				'sort_fields' => $sort_fields,
	            'sort' => $sort,
	            'direction' => $direction,
	        ));
}

if ($viewtype == 'list') {
    if (is_array($entities) && sizeof($entities) > 0) {
        foreach($entities as $entity) {
            $html .= elgg_view_entity($entity, $fullview);
        }
    }
} else {
    if (is_array($entities) && sizeof($entities) > 0) {
        $html .= elgg_view('entities/gallery', array('entities' => $entities));
    }
}

if ($count) {
    $html .= '<div class="clearfloat"></div>' . $nav;
}

echo $html;