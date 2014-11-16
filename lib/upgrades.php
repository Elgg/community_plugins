<?php

function plugins_upgrade_20141107() {
	$options = array(
		'type' => 'object',
		'subtype' => 'plugin_release',
		'limit' => false
	);

	$releases = new ElggBatch('elgg_get_entities', $options);

	foreach ($releases as $release) {
		if ($release->owner_guid != $release->container_guid) {
			
			PluginProject::moveFilesOnSystem($release, $release->container_guid);
			$release->owner_guid = $release->container_guid;
			$release->save();
		}
	}

	// move screenshots
	$options = array(
		'type' => 'object',
		'subtype' => 'plugin_project',
		'limit' => false
	);

	$plugins = new ElggBatch('elgg_get_entities', $options);

	foreach ($plugins as $p) {
		$screenshots = $p->getScreenshots();

		foreach ($screenshots as $s) {
			if ($s->owner_guid != $p->guid) {
				$thumb = get_entity($s->thumbnail_guid);
				
				if ($thumb) {
					$p->moveFilesOnSystem($thumb, $p->guid);
					$thumb->owner_guid = $p->guid;
					$thumb->save();
				}

				$p->moveFilesOnSystem($s, $p->guid);
				$s->owner_guid = $p->guid;
				$s->save();
			}
		}
	}
}
