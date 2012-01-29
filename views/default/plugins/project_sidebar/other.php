<?php
/**
 * Sidebar box for other plugins by developer
 */

$project = $vars['entity'];

$all_user_plugins = elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => 'plugin_project',
	'owner_guid' => $project->owner_guid,
	'limit' => 0,
));

?>
<p><?php echo $project->getOwnerEntity()->name; ?>'s plugins:</p>
<?php

echo "<select class='choose_plugin' onchange=\"window.open(this.options[this.selectedIndex].value,'_top')\">";
foreach ($all_user_plugins as $up) {
	if (get_input('guid') == $up->guid) {
		$selected = "SELECTED";
	} else {
		$selected = '';
	}
	echo "<option value=\"{$up->getURL()}\" $selected>{$up->title}</option>";
}
echo "</select>";
