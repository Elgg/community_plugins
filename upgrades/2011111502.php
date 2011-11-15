<?php
/**
 * bootstrap hash id for plugin updates
 */

global $DB_QUERY_CACHE, $DB_PROFILE, $ENTITY_CACHE, $CONFIG;

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
		$release->setHash();
	}

	$offset += $limit;
}
