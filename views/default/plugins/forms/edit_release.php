<?php
/**
 * Edit release view
 */

if (array_key_exists('release', $vars) && $vars['release'] instanceof PluginRelease) {
	$release = $vars['release'];
	$project = get_entity($release->container_guid);
	$release_input = "<input type=\"hidden\" name=\"release_guid\" value=\"{$release->getGUID()}\" />";
} else {
	$release_input = $release = NULL;
}

?>
<form action="<?php echo $vars['url']; ?>action/plugins/save_release" enctype="multipart/form-data" method="post">

<?php echo elgg_view('plugins/forms/release_details_segment', array('release' => $release, 'project' => $project))?>

<div class="plugins_save_wrapper">
	<?php echo $release_input; ?>
	<?php echo elgg_view('input/securitytoken'); ?>
	<input type="submit" value="<?php echo elgg_echo("save"); ?>" />
</div>

</form>