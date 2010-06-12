<?php

require_once "{$CONFIG->pluginspath}community_plugins/version.php";

$local_version = get_plugin_setting('version', 'community_plugins');

if ($version <= $local_version) {
	register_error('No upgrade required');
	forward(REFERER);
}

$base_dir = $CONFIG->pluginspath . 'community_plugins/upgrades';

// taken from engine/lib/version.php
if ($handle = opendir($base_dir)) {
	$upgrades = array();

	while ($updatefile = readdir($handle)) {
		// Look for upgrades and add to upgrades list
		if (!is_dir("$base_dir/$updatefile")) {
			if (preg_match('/^([0-9]{10})\.(php)$/', $updatefile, $matches)) {
				$plugin_version = (int) $matches[1];
				if ($plugin_version > $local_version) {
					$upgrades[] = "$base_dir/$updatefile";
				}
			}
		}
	}

	// Sort and execute
	asort($upgrades);

	if (sizeof($upgrades) > 0) {
		foreach ($upgrades as $upgrade) {
			include($upgrade);
		}
	}
}

set_plugin_setting('version', $version, 'community_plugins');

system_message("The community plugin repository has been upgraded");

forward(REFERER);
