<?php

//the page owner
$owner = $vars['entity']->owner_guid;

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
	foreach($plugins as $plugin) {
		echo "<div class=\"pluginsrepo_widget_singleitem\">";
		echo "<div class=\"pluginsrepo_listview_icon\"><a href=\"{$plugin->getURL()}\"><img src=\"http://community.elgg.org/mod/community_plugins/graphics/icons/archive.gif\"></a></div>";
		echo "<div class=\"pluginsrepo_widget_content\">";
		echo "<div class=\"pluginsrepo_listview_title\"><p class=\"filerepo_title\">" . $plugin->title . "</p></div>";
		echo "<div class=\"pluginsrepo_listview_date\"><p class=\"filerepo_timestamp\"><small>" . friendly_time($plugin->time_created) . "</small></p></div>";
		echo "</div><div class=\"clearfloat\"></div></div>";

	}

	//get a link to the user's plugins
	$users_file_url = $vars['url'] . "pg/plugins/" . get_user($f->owner_guid)->username;

	echo "<div class=\"pluginsrepo_widget_singleitem_more\"><a href=\"{$users_file_url}\">" . elgg_echo('plugins:more') . "</a></div>";
	echo "</div>";

} else {
	echo "<div class=\"contentWrapper\">" . elgg_echo("plugins:none") . "</div>";
}
