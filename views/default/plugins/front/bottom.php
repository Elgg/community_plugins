<?php
/**
 * Footer for main page
 */


// Note: Not using elgg_extract because these are potentially expensive database queries.
if (!isset($vars['newest'])) {
	$vars['newest'] = elgg_list_entities(array('type' => 'object', 'subtype' => 'plugin_project'));
}

if (!isset($vars['popular'])) {
	$vars['popular'] = elgg_list_entities(array(), 'plugins_get_plugins_by_download_count');
}

if (!isset($vars['recommended'])) {
	$vars['recommended'] = elgg_list_entities_from_annotation_calculation(array(
		'type' => 'object',
		'subtype' => 'plugin_project',
		'annotation_calculation' => 'count',
		'annotation_name' => 'plugin_digg',
	));
}

?>

<div class="elgg-grid mtm">
<?php

// Newest
echo '<div class="elgg-col elgg-col-1of3">';
echo '<div class="elgg-inner" style="border-radius:3px;">';
echo elgg_view_module('info', elgg_echo('plugins:listing:newest'), $vars['newest'], array(
	'footer' => elgg_view('output/url', array(
		'href' => '/plugins/search?sort=created',
		'text' => elgg_echo('plugins:browse_more:newest'),
	)),
));
echo '</div>';
echo '</div>';


echo '<div class="elgg-col elgg-col-1of3">';
echo '<div class="elgg-inner phm" style="border-radius:3px;">';

// Most downloaded
echo elgg_view_module('info', elgg_echo('plugins:listing:popular'), $vars['popular'], array(
	'footer' => elgg_view('output/url', array(
		'href' => '/plugins/search?sort=downloads',
		'text' => elgg_echo('plugins:browse_more:popular'),
	)),
));

echo '</div>';
echo '</div>';


echo '<div class="elgg-col elgg-col-1of3 elgg-col-last">';
echo '<div class="elgg-inner" style="border-radius:3px;">';

// Most recommended
echo elgg_view_module('info', elgg_echo('plugins:listing:dugg'), $vars['recommended'], array(
	'footer' => elgg_view('output/url', array(
		'href' => '/plugins/search?sort=recommendations',
		'text' => elgg_echo('plugins:browse_more:dugg'),
	)),
));

echo '</div>';
echo '</div>';
?>
</div>
