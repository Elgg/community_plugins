<?php

$project = $vars['entity'];

	$ts = time();
	$token = generate_action_token($ts);

	$delete = elgg_view('output/confirmlink',array(
		'href' => $vars['url'] . "action/plugins/delete_project?project_guid={$project->getGUID()}&__elgg_ts=$ts&__elgg_token=$token",
		'text' => 'Delete Project',
		'confirm' => elgg_echo("plugins:delete_project:confirm"),
	));

	?>
<div class="sidebarBox">
	<h3><?php echo elgg_echo('Project Admin'); ?></h3>
	<div class="contentWrapper">
		<ul class="plugins_menu">
			<li><a href="<?php echo $vars['url']; ?>pg/plugins/new/release/<?php echo $project->guid; ?>">Upload New Release</a></li>
			<li><a href="<?php echo $vars['url']; ?>pg/plugins/edit/project/<?php echo $project->guid; ?>">Edit Project Details</a></li>
			<li><?php echo $delete; ?></li>
		</ul>
	</div>
</div>
