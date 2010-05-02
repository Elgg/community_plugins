<?php
/**
 * Elgg file browser uploader
 */

global $CONFIG;
$ts = time();
$token = generate_action_token($ts);

if (array_key_exists('release', $vars)
&& $vars['release'] instanceof FilePluginFile) {
	$release = $vars['release'];
	$project = get_entity($release->container_guid);
	$release_input = "<input type=\"hidden\" name=\"release_guid\" value=\"{$release->getGUID()}\" />";
} else {
	$release_input = $release = NULL;
}

?>
<form action="<?php echo $vars['url']; ?>action/plugins/save_release" enctype="multipart/form-data" method="post">

<?php echo elgg_view('plugins/forms/release_details_segment', array('release' => $release, 'project' => $project))?>

<div class="contentWrapper">
	<?php echo $release_input; ?>
	<input type="hidden"  name="__elgg_token"  value="<?php echo $token; ?>" />
	<input type="hidden"  name="__elgg_ts"  value="<?php echo $ts; ?>" />
	<input type="submit" style="margin:0;" value="<?php echo elgg_echo("save"); ?>" />
</div>

</form>