<?php
/**
 * Sidebar list of categories
 */
?>
<ul>
<?php
// your plugins
if (elgg_is_logged_in()) {
	$params = array(
		'types' => 'object',
		'subtypes' => 'plugin_project',
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'count' => TRUE,
	);
	$count_user_plugins = (int)elgg_get_entities($params);
?>
	<li>
		<a class="plugins_highlight" href="<?php echo elgg_get_site_url(); ?>plugins/developer/<?php echo $vars['user']->username; ?>">
			<?php echo elgg_echo('plugins:myplugins'); ?>
		</a>
		(<?php echo $count_user_plugins; ?>)
	</li>
<?php
}

// all plugins
$all_plugins_count = (int)elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => 'plugin_project',
	'count' => TRUE,
));
$url = elgg_get_site_url() . "plugins/category/all";
?>
	<li>
		<a class="plugins_highlight" href="<?php echo $url; ?>">
			<?php echo elgg_echo('plugins:cat:all'); ?>
		</a>
		(<?php echo $all_plugins_count; ?>)
	</li>
<?php

// categories
$params = array(
	'types' => 'object',
	'subtypes' => 'plugin_project',
	'count' => TRUE,
);
foreach (elgg_get_config('plugincats') as $value => $option) {
	$params['metadata_name'] = 'plugincat';
	$params['metadata_value'] = $value;
	$counter = (int)elgg_get_entities_from_metadata($params);
	echo "<li><a href=\"" . elgg_get_site_url() . "plugins/category/{$value}\">".$option."</a> ({$counter})</li>";
}
?>
</ul>
