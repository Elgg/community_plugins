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

elgg_set_context('plugin_project');

$welcome = elgg_view('plugins/front/main');
$sidebar = elgg_view('plugins/filters', array(
	'categories' => $CONFIG->plugincats,
	'versions' => $CONFIG->elgg_versions,
	'licences' => $CONFIG->gpllicenses,
	'settings' => $settings

));
$bottom = elgg_view('plugins/front/bottom');

$body = elgg_view_layout('plugins_layout', array(
	'content' => $welcome,
	'sidebar' => $sidebar,
	'bottom' => $bottom,
));

echo elgg_view_page(elgg_echo("plugins:all"), $body);
