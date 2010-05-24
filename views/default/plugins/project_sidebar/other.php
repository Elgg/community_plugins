<?php

$project = $vars['entity'];

$all_user_plugins = get_entities("object", "plugin_project", $project->owner_guid,"", 99, 0);

if (count($all_user_plugins) > 1) {
?>
<div class="sidebarBox">
	<h3>Other Projects</h3>
	<div class="contentWrapper">
		<p><?php echo page_owner_entity()->name; ?>'s plugins:</p>
	<?php
		if($all_user_plugins){
			echo "<select class='choose_plugin' onchange=\"window.open(this.options[this.selectedIndex].value,'_top')\">";
			foreach($all_user_plugins as $up){
				if(get_input('guid') == $up->guid)
					$selected = "SELECTED";
				else
					$selected = '';
				echo "<option value=\"{$up->getURL()}\" $selected>{$up->title}</option>";
			}
			echo "</select>";
		}
	?>
	</div>
</div>
<?php
}
?>
