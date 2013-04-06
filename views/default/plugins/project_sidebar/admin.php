<?php
/**
 * Project admin - edit, new release, delete
 */

$project = $vars['entity'];

$delete = elgg_view('output/confirmlink', array(
	'href' => "/action/plugins/delete_project?project_guid={$project->getGUID()}",
	'text' => 'Delete Project',
	'confirm' => elgg_echo("plugins:delete_project:confirm"),
));
	
$transfer = elgg_view('output/url', array(
	'href' => "/plugins/transfer/{$project->getGUID()}",
	'text' => 'Transfer Ownership'
));

?>
<ul class="plugins_menu">
	<li><a href="<?php echo elgg_get_site_url(); ?>plugins/new/release/<?php echo $project->guid; ?>">Upload New Release</a></li>
	<li><a href="<?php echo elgg_get_site_url(); ?>plugins/edit/project/<?php echo $project->guid; ?>">Edit Project Details</a></li>
	<?php
	if (elgg_is_admin_logged_in()) {
	  echo "<li>$transfer</li>";
	}
	?>
	<li><a href="<?php echo elgg_get_site_url(); ?>plugins/contributors/<?php echo $project->guid; ?>">Add Contributors</a></li>
	<li><?php echo $delete; ?></li>
</ul>
