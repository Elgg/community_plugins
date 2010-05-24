<?php
$project = $vars['entity'];

$dls = (int)get_annotations_sum($project->guid, '', '', 'download');

?>

<div class="sidebarBox pluginsrepo_details">
	<h3><?php echo elgg_echo('Stats'); ?></h3>
	<div class="contentWrapper">
		<ul class="plugin_details">
			<li><b><?php echo elgg_echo('plugins:category'); ?>:</b> <a href="<?php echo $vars['url']; ?>pg/plugins/category/<?php echo $project->plugincat; ?>"><?php echo $project->plugincat; ?></a></li>
			<li><b><?php echo elgg_echo('license'); ?>:</b> <?php echo elgg_echo('license:' . $project->license); ?></li>
			<li><b><?php echo elgg_echo('plugins:updated'); ?>:</b> <?php echo date("Y-n-j", $project->time_updated); ?></li>
			<li><b>Downloads: </b> <?php echo $dls; ?></li>
		</ul>
	</div>
</div>
