<?php
/**
 * Project admin - edit, new release, delete
 */

$project = $vars['entity'];

$ts = time();
$token = generate_action_token($ts);

$delete = elgg_view('output/confirmlink',array(
	'href' => "/action/plugins/delete_project?project_guid={$project->getGUID()}&__elgg_ts=$ts&__elgg_token=$token",
	'text' => 'Delete Project',
	'confirm' => elgg_echo("plugins:delete_project:confirm"),
));

?>
<ul class="plugins_menu">
	<li><a href="<?php echo elgg_get_site_url(); ?>plugins/new/release/<?php echo $project->guid; ?>">Upload New Release</a></li>
	<li><a href="<?php echo elgg_get_site_url(); ?>plugins/edit/project/<?php echo $project->guid; ?>">Edit Project Details</a></li>
	<li><?php echo $delete; ?></li>
</ul>
