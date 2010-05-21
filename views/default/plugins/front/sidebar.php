<?php
?>
<h2><?php echo elgg_echo('plugins:categories'); ?></h2>
<ul>
<?php
// your plugins
if (isloggedin()) {
	$count_user_plugins = (int)get_entities("object", "plugin_project", get_loggedin_userid(), "", 10, 0, true);
?>
	<li>
		<a class="plugins_highlight" href="<?php echo $vars['url']; ?>pg/plugins/developer/<?php echo $vars['user']->username; ?>"><?php echo elgg_echo('plugins:myplugins'); ?></a>
		(<?php echo $count_user_plugins; ?>)
	</li>
<?php
}

// all plugins
$all_plugins_count = (int)get_entities("object", "plugin_project", 0, "", 0, 0, true);
$url = $vars['url'] . "pg/plugins/category/all";
?>
	<li>
		<a class="plugins_highlight" href="<?php echo $url; ?>"><?php echo elgg_echo('plugins:cat:all'); ?></a>
		(<?php echo $all_plugins_count; ?>)
	</li>
<?php

// categories
foreach ($vars['config']->plugincats as $value => $option) {
	$counter = (int)get_entities_from_metadata("plugincat", $value, "object", "plugin_project",0,10,0,"",0,true);
	echo "<li><a href=\"{$vars['url']}pg/plugins/category/{$value}\">".$option."</a> ({$counter})</li>";
}
?>
</ul>
