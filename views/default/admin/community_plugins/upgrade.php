<?php

require_once elgg_get_plugins_path() . 'community_plugins/version.php';

$local_version = elgg_get_plugin_setting('version', 'community_plugins');

// bootstrap version detection for newly activated or never been upgraded plugin
if ($local_version === FALSE) {
	$dbprefix = elgg_get_config('dbprefix');

	// original subtype before version 1
	$subtype_info = get_data_row("SELECT * from {$dbprefix}entity_subtypes
		WHERE type='object' AND subtype='plugin_file'");

	if ($subtype_info != FALSE) {
		// never been upgraded
		$local_version = 0;
	} else {
		$local_version = $version;
	}
	elgg_set_plugin_setting('version', $local_version, 'community_plugins');
}

if ($version > $local_version) {
	echo elgg_view('output/longtext', array('value' => elgg_echo('plugins:admin:upgrade:required')));
	echo elgg_view_form('plugins/admin/upgrade');
} else {
	echo elgg_view('output/longtext', array('value' => elgg_echo('plugins:admin:upgrade:ok')));
}


