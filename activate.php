<?php

if (get_subtype_id('object', 'plugin_release')) {
	update_subtype('object', 'plugin_release', 'PluginRelease');
} else {
	add_subtype('object', 'plugin_release', 'PluginRelease');
}
if (get_subtype_id('object', 'plugin_project')) {
	update_subtype('object', 'plugin_project', 'PluginProject');
} else {
	add_subtype('object', 'plugin_project', 'PluginProject');
}

/**
 * Creates the table for the plugin download count
 * TODO: Switch this to InnoDB and use foreign keys on entity table?
 */
$db_prefix = elgg_get_config('dbprefix');
$sql = "CREATE TABLE IF NOT EXISTS `{$db_prefix}plugin_downloads` (
	`guid` BIGINT UNSIGNED NOT NULL,
	`downloads` INT UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (`guid`),
	KEY `downloads` (`downloads`)
) ENGINE=MyISAM";

update_data($sql);