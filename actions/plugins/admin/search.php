<?php 

	$settings_array = get_input('search_settings', array());
	$forward_url = $_SERVER['HTTP_REFERER'];
	
	if (!is_array($settings_array)) {
		register_error(elgg_echo('plugins:settings:save:failure'));
		forward($forward_url);
	}
	
	// For the sake of simplicity, lets serialize the whole array and store it as a single string in private settings
	$settings = serialize($settings_array);
	elgg_set_plugin_setting('search-settings', $settings, 'community_plugins');
	
	system_message(elgg_echo('plugins:settings:save:success'));
	forward($forward_url);
?>