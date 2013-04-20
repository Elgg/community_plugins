<?php
/**
 * Sidebar box for list of releases
 */

$project = $vars['entity'];

// show author recommened and latest
// but only once.
$ignore_guids = array();

// check that it's a real entity and we have access to it
if ($recommended = $project->getRecommendedRelease()) {
	$ignore_guids[] = $recommended->guid;

	echo elgg_view('object/plugin_release/links', array(
		'entity' => $recommended,
		'label' => elgg_echo('plugins:author:recommended'),
	));
}

//get all releases associated with the project
$plugins = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'plugin_release',
	'container_guid' => $project->guid,
	'limit' => 0,
));

if ($plugins) {
	// display latest
	// @todo should this display in addition to the recommended if they're the same?
	$latest = $plugins[0];
	if ($latest && $latest->guid != $project->recommended_release_guid) {
		unset($plugins[0]);
		$ignore_guids[] = $latest->guid;

		echo elgg_view('object/plugin_release/links', array(
			'entity' => $latest,
			'label' => 'Latest',
		));
	}
}

echo '<hr style="margin: 0.5em 0;"/>';
echo 'Previous releases:';
	
if ($plugins) {
	foreach ($plugins as $p) {
		if (in_array($p->getGUID(), $ignore_guids)) {
			continue;
		}
		echo elgg_view('object/plugin_release/links', array('entity' => $p));
	}
} else {
	echo '<div class="plugins_release_links">' . elgg_echo('None') . '</div>';
}
