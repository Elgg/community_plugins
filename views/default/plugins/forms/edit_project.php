<?php
/**
 * Edit project view
 */

if (array_key_exists('project', $vars)
&& $vars['project'] instanceof ElggObject
&& $vars['project']->getSubtype() == 'plugin_project') {
		$project = $vars['project'];
		$project_input = "<input type=\"hidden\" name=\"plugins_guid\" value=\"{$project->getGUID()}\" />";
} else {
	$project_input = $project = NULL;
}

?>
<form action="<?php echo elgg_get_site_url(); ?>action/plugins/save_project" enctype="multipart/form-data" method="post">

<?php echo elgg_view('plugins/forms/project_details_segment', array('project' => $project)); ?>

<div class="plugins_save_wrapper">
	<?php echo $project_input; ?>
	<?php echo elgg_view('input/securitytoken'); ?>
	<input type="submit" value="<?php echo elgg_echo("save"); ?>" />
</div>

</form>
