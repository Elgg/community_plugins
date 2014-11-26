<?php

namespace Elgg\CommunityPlugins;
use ElggBatch;

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

function upgrade_20141125() {
	
	$version = (int) elgg_get_plugin_setting('version', PLUGIN_ID);
	if ($version == 2011111502) {
		// this didn't happen correctly in the last upgrade
		// due to some legacy setting
		elgg_set_plugin_setting('version', 20141121, PLUGIN_ID);
		$version = 20141121;
	}
	
	if ($version >= UPGRADE_VERSION) {
		return true;
	}
	
	$options = array(
		'type' => 'object',
		'subtype' => 'plugin_project',
		'limit' => false
	);
	
	$batch = new ElggBatch('elgg_get_entities', $options);
	
	foreach ($batch as $plugin) {
		// get most recent release
		$releases = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'plugin_release',
			'container_guid' => $plugin->guid,
			'limit' => 1,
			'callback' => false // keep it quick as possible
		));
		
		if ($releases[0]->time_created) {
			update_entity_last_action($plugin->guid, $releases[0]->time_created);
		}
		else {
			update_entity_last_action($plugin->guid, $plugin->time_created);
		}
	}
	
	elgg_set_plugin_setting('version', 20141125, PLUGIN_ID);
}