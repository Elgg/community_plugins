<?php

require_once "{$CONFIG->pluginspath}community_plugins/version.php";

$local_version = get_plugin_setting('version', 'community_plugins');

// bootstrap version detection for newly activated or never been upgraded plugin
if ($local_version === FALSE) {
	// original subtype before version 1
	$subtype_info = get_data_row("SELECT * from {$CONFIG->dbprefix}entity_subtypes
		WHERE type='object' AND subtype='plugin_file'");

	if ($subtype_info != FALSE) {
		// never been upgraded
		$local_version = 0;
	} else {
		$local_version = $version;
	}
	set_plugin_setting('version', $local_version, 'community_plugins');
}

if ($version > $local_version) {
	echo "<p>An upgrade is required for this plugin.</p>";
	$url = "{$CONFIG->wwwroot}action/plugins/upgrade";
	$link = elgg_view('output/url', array('text' => 'Upgrade',
										'href' => $url,
										'is_action' => TRUE));
	echo "<p>$link</p>";
} else {
	echo "<p>No upgrades required.</p>";
}


