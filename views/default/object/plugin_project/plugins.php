<?php
/** @var PluginProject */
$project = $vars['entity'];

$release = $vars['release'];

// get required variables
$project_owner = $project->getOwnerEntity();
$updated = elgg_view_friendly_time($project->getLatestRelease()->time_created);

?>

<div class="plugins_wrapper">
	<div class="plugins_owner_wrapper">
	<?php 
		echo elgg_view('output/url', array(
			'href' => '/plugins',
			'text' => 'back to plugins',
			'class' => 'plugins_back_link',
		));
	?>
	<h2>
	<?php 
		echo elgg_view('output/url', array(
			'href' => $project->getURL(),
			'text' => $project->title,
			'encode_text' => TRUE,
		));
	?>
	</h2>
		<div class="pluginsrepo_owner">
			<?php echo elgg_view_entity_icon($project_owner, 'tiny'); ?>
			<p class="pluginsrepo_owner_details">
				<b>by <a href="<?php echo elgg_get_site_url(); ?>plugins/developer/<?php echo $project_owner->username; ?>"><?php echo $project_owner->name; ?></a></b><br />
				<small><b>Last updated</b> <?php echo $updated; ?></small>
			</p>
			<div class="pluginsrepo_tags">
				<div class="object_tag_string">
					<?php echo elgg_view('output/tags', array('value' => $project->tags)); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="plugins_maincontent">
		<?php echo elgg_view('plugins/recommend', array('project' => $project)); ?>
		<h4>Summary:</h4>
		<?php echo autop($summary); ?>
		<h4>Full description:</h4>
		<?php echo autop($project->description); ?>
	</div>
</div>
<?php

if ($release) {
	echo elgg_view_entity($release);
}
