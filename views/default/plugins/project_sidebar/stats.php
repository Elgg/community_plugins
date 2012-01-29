<?php
/**
 * Project stats
 */

$project = $vars['entity'];

?>

<ul class="plugin_stats">
	<li><b><?php echo elgg_echo('plugins:category'); ?>:</b> <a href="<?php echo elgg_get_site_url(); ?>plugins/category/<?php echo $project->plugincat; ?>"><?php echo $CONFIG->plugincats[$project->plugincat]; ?></a></li>
	<li><b><?php echo elgg_echo('license'); ?>:</b> <?php echo elgg_echo('license:' . $project->license); ?></li>
	<li><b><?php echo elgg_echo('plugins:updated'); ?>:</b> <?php echo date("Y-n-j", $project->time_updated); ?></li>
	<li><b>Downloads: </b> <?php echo $project->getDownloadCount(); ?></li>
</ul>
