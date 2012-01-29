<?php
echo '<p>';
echo 'Remove inflated download counts for the currently graphed plugin<br />';
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));

echo elgg_view('input/submit', array('value' => elgg_echo('Normalize')));

echo ' ';  // yes, this should be CSS

echo elgg_view('output/url', array(
	'href' => "/plugins/admin/normalize?guid=$guid&preview=true",
	'text' => elgg_echo('Preview'),
	'is_action' => TRUE,
));

echo '</p>';
