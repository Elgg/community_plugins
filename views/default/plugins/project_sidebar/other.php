<?php

$project = $vars['entity'];

$params = array(
	'types' => 'object',
	'subtypes' => 'plugin_project',
	'owner_guid' => $project->owner_guid,
	'limit' => 0,
);
$all_user_plugins = elgg_get_entities($params);

if (count($all_user_plugins) > 1) {
?>
<div class="sidebarBox">
	<h3>Other Projects</h3>
	<div class="contentWrapper">
		<p><?php echo page_owner_entity()->name; ?>'s plugins:</p>
<?php
		if ($all_user_plugins) {
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
		}
?>
	</div>
</div>
<?php
}
