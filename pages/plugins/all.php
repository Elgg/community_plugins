<?php
/**
 * Front page for plugin repository
 */

global $CONFIG; 

// Get search-specific settings
$serialized_settings = elgg_get_plugin_setting('search-settings', 'community_plugins');
$settings = unserialize($serialized_settings);
if (!is_array($settings)) {
	$settings = array();
}

//Newest
$newest = elgg_get_entities(array('type' => 'object', 'subtype' => 'plugin_project'));

//Most downloaded
$popular = PluginProject::getPluginsByDownloads();

//Most dugg
$dugg = __get_entities_from_annotations_calculate_x('count', 'object', 'plugin_project', 'plugin_digg');

set_context('plugin_project');

$welcome = elgg_view('plugins/front/main');
$sidebar = elgg_view('plugins/filters', array(
	'categories' => $CONFIG->plugincats,
	'versions' => $CONFIG->elgg_versions,
	'licences' => $CONFIG->gpllicenses,
	'settings' => $settings

));
$bottom = elgg_view('plugins/front/bottom', array(	'newest' => $newest,
													'popular' => $popular,
													'dugg' => $dugg,));


$body = elgg_view_layout('plugins_layout', $welcome, $sidebar, $bottom);

page_draw(elgg_echo("plugins:all"), $body);
