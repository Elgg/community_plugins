<?php
/**
 * Filters for search
 * 
 * @uses $vars Passes it to 'plugins/search/form' view
 */

$serialized_settings = elgg_get_plugin_setting('search-settings', 'community_plugins');
$settings = unserialize($serialized_settings);
if (!is_array($settings)) {
	$settings = array();
}

$vars['settings'] = $settings;

echo elgg_view_module(
		'aside',
		elgg_echo('plugins:filters:title'),
		elgg_view('plugins/search/form', $vars),
		array('class' => 'plugin-search')
);