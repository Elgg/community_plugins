<?php
/**
 * Elgg file browser uploader
 */

global $CONFIG;
$ts = time();
$token = generate_action_token($ts);

if (array_key_exists('project', $vars)
&& $vars['project'] instanceof ElggObject
&& $vars['project']->getSubtype() == 'plugin_project') {
		$project = $vars['project'];
		$project_input = "<input type=\"hidden\" name=\"plugins_guid\" value=\"{$project->getGUID()}\" />";
} else {
	$project_input = $project = NULL;
}

$project_url = "{$vars['url']}pg/plugins/" . get_loggedin_user()->username . "/read/{$vars['entity']->guid}";

?>
<form action="<?php echo $vars['url']; ?>action/plugins/save_project" enctype="multipart/form-data" method="post">

<?php echo elgg_view('plugins/forms/project_details_segment', array('project' => $vars['project']))?>

<div class="contentWrapper">
	<?php echo $project_input; ?>
	<input type="hidden"  name="__elgg_token"  value="<?php echo $token; ?>" />
	<input type="hidden"  name="__elgg_ts"  value="<?php echo $ts; ?>" />
	<input type="submit" style="margin:0;" value="<?php echo elgg_echo("save"); ?>" />
</div>

</form>