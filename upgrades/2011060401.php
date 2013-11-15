<?php
/**
 * removing versions 1.6.1 and 1.7a
 */

global $DB_QUERY_CACHE, $DB_PROFILE, $ENTITY_CACHE, $CONFIG;

// poorly implemented logging can use up all our memory (fixed in 1.8.0)
elgg_unregister_event_handler('all', 'all', 'system_log_listener');
elgg_unregister_event_handler('log', 'systemlog', 'system_log_default_logger');

$limit = 50;
$offset = 0;

while (true) {
	// make sure the caches don't use up all our memory
	$DB_QUERY_CACHE = $DB_PROFILE = $ENTITY_CACHE = array();

	$releases = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'plugin_release',
		'limit' => $limit,
		'offset' => $offset,
	));
	if (!$releases) {
		break;
	}

	foreach ($releases as $release) {
		if (!isset($release->elgg_version)) {
			$release->elgg_version = 1.0;
		} else {
			switch ($release->elgg_version) {
				case '1.0':
				case '1.2':
				case '1.5':
				case '1.6':
				case '1.7':
				case '1.8':
					break;
				case '1.6.1':
					$release->elgg_version = '1.6';
					break;
				case '1.7a':
					$release->elgg_version = '1.7';
					break;
				default:
					// best guess
					error_log("Unexpected version $release->elgg_version when upgrading plugin repo");
					$release->elgg_version = '1.5';
					break;
			}
		}
	}

	$offset += $limit;
}