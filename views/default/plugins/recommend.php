<?php
/**
 * Recommend view
 */

$project = $vars['project'];
$num_votes = count_annotations($project->guid, "object", "plugin_project", "plugin_digg");
?>

<div id="plugins_recommend">
	<div id="num_recommend">
		<p><?php echo $num_votes; ?></p>
	</div>
	<div class="clearfloat"></div>
	<div id="recommend_action">
<?php
if (!plugins_is_dugg($project) && isloggedin()) {
	$url = "{$vars['url']}action/plugins/recommend?guid={$project->guid}";
	$url = elgg_add_action_tokens_to_url($url);
	echo "<a href=\"{$url}\">Recommend</a>";
} else {
?>
		<p>Recommendations</p>
<?php
}
?>
	</div>
</div>