<?php
/**
 * Footer for main page
 */

?>
<div id="plugin_three_column">
<?php
echo elgg_view('plugins/front/listing', array(
	'type' => 'newest',
	'plugins' => $vars['newest'],
));

echo elgg_view('plugins/front/listing', array(
	'type' => 'popular',
	'plugins' => $vars['popular'],
));

echo elgg_view('plugins/front/listing', array(
	'type' => 'dugg',
	'plugins' => $vars['recommended'],
));

?>
</div>
