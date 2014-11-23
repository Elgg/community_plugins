<?php

namespace Elgg\CommunityPlugins;

// start using plugin setting version to handle future upgrades
function upgrade_20141121() {
	$version = (int) elgg_get_plugin_setting('version', PLUGIN_ID);
	error_log('upgrading community plugins');
	if ($version >= UPGRADE_VERSION) {
		return true;
	}
	error_log('setting version');
	elgg_set_plugin_setting('version', 20141121, PLUGIN_ID);
}
