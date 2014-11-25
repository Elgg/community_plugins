<?php
/**
 * Widget content
 */

//the page owner
$owner = $vars['entity']->owner_guid;
$owner_entity = get_entity($owner);

//the number of files to display
$number = (int) $vars['entity']->num_display;
if (!$number) {
	$number = 4;
}

//get the user's plugin projects
$options = array(
	'owner_guids' => array($vars['entity']->owner_guid),
	'types' => array('object'),
	'subtypes' => array('plugin_project'),
	'limit' => $number,
	'offset' => 0,
	'order_by' => 'e.last_action DESC',
	'pagination' => false,
);

$plugins = elgg_list_entities($options);

echo $plugins;

if ($plugins) {
	$more_link = elgg_view('output/url', array(
		'href' => "/plugins/developer/$owner_entity->username",
		'text' => elgg_echo('plugins:more'),	
		'is_trusted' => true,
	));

	echo "<span class=\"elgg-widget-more\">$more_link</span>";

} else {
	echo elgg_echo("plugins:none");
}
