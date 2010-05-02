<?php
/**
 * Elgg plugin update
 */

global $CONFIG;
$ts = time();
$token = generate_action_token($ts);

if (array_key_exists('project', $vars) && $vars['project'] instanceof ElggObject) {
	$project_guid = $vars['project']->getGUID();
}

?>
<form action="<?php echo $vars['url']; ?>action/plugins/update" enctype="multipart/form-data" method="post">
	<?php echo elgg_view('plugins/forms/release_details_segment', $vars); ?>
	<?php echo elgg_view("input/hidden", array("internalname" => "guid","value" => $project_guid,)); ?>
	<input type="hidden"  name="__elgg_token"  value="<?php echo $token; ?>" />
	<input type="hidden"  name="__elgg_ts"  value="<?php echo $ts; ?>" />
	<input type="submit" value="<?php echo elgg_echo("save"); ?>" />
</form>