<?php
/**
 * Recommend view
 */

$project = $vars['project'];

$num_votes = $project->countAnnotations('plugin_digg');

?>

<div id="plugins_recommend">
	<div id="num_recommend">
		<p><?php echo $num_votes; ?></p>
	</div>
	<div class="clearfloat"></div>
	<div id="recommend_action">
<?php
if (!plugins_is_dugg($project) && elgg_is_logged_in()) {
	echo elgg_view('output/url', array(
		'href' => "/action/plugins/recommend?guid={$project->guid}",
		'is_action' => TRUE,
		'text' => 'Recommend',
	));
} else {
	echo "<p>Recommendations</p>";
}
?>
	</div>
</div>