<?php
/**
 * Elgg file browser uploader
 */

global $CONFIG;
$ts = time();
$token = generate_action_token($ts);

?>
<form action="<?php echo $vars['url']; ?>action/plugins/upload" enctype="multipart/form-data" method="post">

<?php echo elgg_view('plugins/forms/project_details_segment'); ?>
<?php echo elgg_view('plugins/forms/release_details_segment'); ?>

<p>
	<?php
	if (isset($vars['container_guid'])) {
		echo "<input type=\"hidden\" name=\"container_guid\" value=\"{$vars['container_guid']}\" />";
	}

	if (isset($vars['entity'])) {
		echo "<input type=\"hidden\" name=\"plugins_guid\" value=\"{$vars['entity']->getGUID()}\" />";
	}
	?>
	<input type="hidden"  name="__elgg_token"  value="<?php echo $token; ?>" />
	<input type="hidden"  name="__elgg_ts"  value="<?php echo $ts; ?>" />
	<input type="submit" value="<?php echo elgg_echo("save"); ?>" />
</p>

</form>