<?php
/**
 * Project stats
 */

$project = $vars['entity'];
$plugin_categories = elgg_get_config('plugincats');

?>

<ul class="plugin_stats">
	<li><b><?php echo elgg_echo('plugins:category'); ?>:</b> <a href="<?php echo elgg_get_site_url(); ?>plugins/category/<?php echo $project->plugincat; ?>"><?php echo $plugin_categories[$project->plugincat]; ?></a></li>
	<li><b><?php echo elgg_echo('license'); ?>:</b> <?php echo elgg_echo('license:' . $project->license); ?></li>
	<li><b><?php echo elgg_echo('plugins:updated'); ?>:</b> <?php echo date("Y-n-j", $project->time_updated); ?></li>
	<li><b><?php echo elgg_echo('plugins:downloads'); ?>: </b> <?php echo $project->getDownloadCount(); ?></li>
	<li><b><?php echo elgg_echo('plugins:recommendations'); ?>: </b> <?php echo $project->countDiggs(); ?></li>
</ul>
