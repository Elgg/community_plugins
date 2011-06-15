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
$plugins = get_user_objects($vars['entity']->owner_guid, "plugin_project", $number, 0);

if ($plugins) {
	echo "<div id=\"pluginsrepo_widget_layout\">";
	
	//display in list mode
	$context = get_context();
	set_context('widget');
	foreach ($plugins as $plugin) {
		echo elgg_view_entity($plugin);
	}
	set_context($context);

	//get a link to the user's plugins
	$users_file_url = $vars['url'] . "pg/plugins/developer/" . $owner_entity->username;

	echo "<div class=\"pluginsrepo_widget_singleitem_more\"><a href=\"{$users_file_url}\">" . elgg_echo('plugins:more') . "</a></div>";
	echo "</div>";

} else {
	echo "<div class=\"contentWrapper\">" . elgg_echo("plugins:none") . "</div>";
}
