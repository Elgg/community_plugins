<?php
/**
 * bootstrap download count table
 */

global $DB_QUERY_CACHE, $DB_PROFILE, $ENTITY_CACHE, $CONFIG;

$limit = 50;
$offset = 0;

$db_prefix = $CONFIG->dbprefix;

while (true) {
	// make sure the caches don't use up all our memory
	$DB_QUERY_CACHE = $DB_PROFILE = $ENTITY_CACHE = array();

	$plugins = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'plugin_project',
		'limit' => $limit,
		'offset' => $offset,
	));
	if (!$plugins) {
		break;
	}

	foreach ($plugins as $plugin) {
		$guid = $plugin->getGUID();
		$count = $plugin->countAnnotations('download');
		$sql = "INSERT INTO {$db_prefix}plugin_downloads
			(guid, downloads) VALUES ($guid, $count)
			ON DUPLICATE KEY UPDATE downloads = $count";
		insert_data($sql);
	}

	$offset += $limit;
}
