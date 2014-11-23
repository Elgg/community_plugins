<?php

namespace Elgg\CommunityPlugins;
use PluginProject;

/**
 * Get the mimetype of the plugin archive
 *
 * @param string $name
 * @return string/bool
 */
function get_mimetype($name) {
	// We're only allowing archives.
	if (!substr_count($_FILES[$name]['name'],'.tar.gz') &&
		!substr_count($_FILES[$name]['name'],'.tgz') &&
		!substr_count($_FILES[$name]['name'],'.zip')) {

		return FALSE;
	}

	if (substr_count($_FILES[$name]['name'],'.tar.gz') ||
		substr_count($_FILES[$name]['name'],'.tgz')) {

		return 'application/x-gzip';
	} else {
		return 'application/zip';
	}
}

/**
 * Strip img and link tags
 *
 * @param string $string
 * @return string
 */
function plugins_strip_tags($string) {
	return strip_tags($string, '<p><strong><em><span><ul><li><ol><blockquote>');
}

/**
 * Get the download trends
 *
 * @param int $guid Plugin project guid or 0 for all plugins
 * @param int $days Number of days starting from today or 0 for dawn of time
 * @return array
 */
function get_downloads_histogram($guid = 0, $days = 30) {
	$start_date = time() - $days * 3600 * 24;
	if ($days == 0) {
		$start_date = 0;
	}

	$downloads = elgg_get_annotations(array(
		'guid' => $guid,
		'limit' => 0,
		'order_by' => 'time_created asc',
		'annotation_name' => 'download',
		'annotation_created_time_lower' => $start_date,
	));

	// if queried for all downloads, need to set epoch based on first download
	$first_time = $downloads[0]->time_created;
	$num_actual_days = (int)(time() - $first_time) / (3600 * 24) + 1;
	if ($start_date == 0) {
		$start_date = $first_time;
		$days = max($days, $num_actual_days);
	}

	// compute histogram of downloads
	$histogram = array_fill(0, $days, 0);
	foreach ($downloads as $download) {
		$day = (int)floor(($download->time_created - $start_date) / (3600 * 24));
		$histogram[$day]++;
	}

	return $histogram;
}



/**
 * Return the count of all downloads
 *
 * @return int
 */
function get_all_download_count() {
	// the cached count is maintained in PluginProject::updateDownloadCount
	return (int)elgg_get_plugin_setting('site_plugins_downloads', 'community_plugins');
}

// TODO(evan): This is why we need to use call_user_func_array in elgg_list_entities...
function get_plugins_by_download_count(array $options = array()) {
	return PluginProject::getPluginsByDownloads($options);
}


/**
 * Add a sidebar menu of plugin types for this developer
 *
 * @param int $owner_guid The GUID of the owner of the plugins
 */
function add_type_menu($owner_guid) {
	$owner = get_entity($owner_guid);
	if (!$owner) {
		return;
	}

	$plugin_types = elgg_get_tags(array(
		'threshold' => 0,
		'limit' => 10,
		'tag_names' => array('plugin_type'),
		'type' => 'object',
		'subtype' => 'plugin_project',
		'container_guid' => $owner_guid,
	));

	if ($plugin_types) {
		foreach ($plugin_types as $type) {

			$tag = $type->tag;
			$label = elgg_echo("plugins:type:" . $tag);

			$url = "/plugins/developer/$owner->username/type/$tag/";

			elgg_register_menu_item('page', array('name' => $label, 'text' => $label, 'href' => $url));
		}
	}
}


function register_js() {
	elgg_define_js('jquery.flot', array(
		'src' => '/mod/community_plugins/vendors/flot/jquery.flot.js',
		'deps' => array('jquery')
	));
	
	elgg_register_css('jquery.chosen', '/mod/community_plugins/vendors/chosen/chosen.min.css');
	elgg_define_js('jquery.chosen', array(
		'src' => '/mod/community_plugins/vendors/chosen/chosen.jquery.min.js',
		'deps' => array('jquery')
	));
	
	elgg_register_css('smoothproducts', '/mod/community_plugins/vendors/Smoothproducts/css/smoothproducts.css');
	elgg_define_js('smoothproducts', array(
		'src' => '/mod/community_plugins/vendors/Smoothproducts/js/smoothproducts.min.js',
		'deps' => array('jquery')
	));
}