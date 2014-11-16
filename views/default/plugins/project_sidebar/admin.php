<?php
/**
 * Project admin - edit, new release, delete
 */

$project = $vars['entity'];

$delete = elgg_view('output/confirmlink', array(
	'href' => "/action/plugins/delete_project?project_guid={$project->getGUID()}",
	'text' => elgg_echo('plugins:delete:project'),
	'confirm' => elgg_echo("plugins:delete_project:confirm"),
));

$ownership_requests = elgg_view('output/url', array(
	'href' => "/plugins/{$project->getGUID()}/ownership_requests",
	'text' => elgg_echo('plugins:requests:ownership'),
));

$transfer = elgg_view('output/url', array(
	'href' => "/plugins/transfer/{$project->getGUID()}",
	'text' => elgg_echo('plugins:transfer:ownership'),
));

?>
<ul class="plugins_menu">
	<li><a href="<?php echo elgg_get_site_url(); ?>plugins/new/release/<?php echo $project->guid; ?>"><?php echo elgg_echo('plugins:new:release'); ?></a></li>
	<li><a href="<?php echo elgg_get_site_url(); ?>plugins/edit/project/<?php echo $project->guid; ?>"><?php echo elgg_echo('plugins:edit:project'); ?></a></li>
	<?php
	if (elgg_is_admin_logged_in()) {
		echo "<li>$ownership_requests</li>";
		echo "<li>$transfer</li>";
	}
	?>
	<li><a href="<?php echo elgg_get_site_url(); ?>plugins/contributors/<?php echo $project->guid; ?>"><?php echo elgg_echo('plugins:contributors:add'); ?></a></li>
	<li><?php echo $delete; ?></li>
</ul>
