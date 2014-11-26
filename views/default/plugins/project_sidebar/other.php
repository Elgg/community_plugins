<?php
/**
 * Sidebar box for other plugins by developer
 */

$project = $vars['entity'];

$dbprefix = elgg_get_config('dbprefix');
$all_user_plugins = elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => 'plugin_project',
	'owner_guid' => $project->owner_guid,
	'joins' => array(
		"JOIN {$dbprefix}objects_entity oe ON oe.guid = e.guid"
	),
	'order_by' => "oe.title ASC",
	'limit' => 0,
));

echo '<p>' . elgg_echo('plugins:user:plugin', array($project->getOwnerEntity()->name)) . '</p>';

echo "<select class='choose_plugin' onchange=\"window.open(this.options[this.selectedIndex].value,'_top')\">";
foreach ($all_user_plugins as $up) {
	if ($project->guid == $up->guid) {
		$selected = "SELECTED";
	} else {
		$selected = '';
	}
	echo "<option value=\"{$up->getURL()}\" $selected>{$up->title}</option>";
}
echo "</select>";
