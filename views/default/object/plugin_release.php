<?php
/**
 * Plugin release
 * 
 */

$release = $vars['entity'];
$project = $release->getProject();
$notes = $release->release_notes;
echo "<div id=\"download_action\">";
if ($project->recommended_release_guid && $project->recommended_release_guid != $release->getGUID()) {
	$author = $project->getOwnerEntity();
	$recommended_link = $project->getRecommendedRelease()->getUrl();
	$recommended = get_entity($project->recommended_release_guid);
	echo <<<___END
	<div class="elgg-message elgg-state-error">
		<div id="warning"></div>
		<h3>Warning!</h3>
		<p>The author recommends using a different release of this plugin!</p>
		<ul>
		<li><a href="$recommended_link">View recommended release ({$recommended->version})</a></li>
		<li><a href="$dl_link">I understand the potential risks and want this release.</a></li>
		</ul>
		<div class="clearfloat"></div>
	</div>
___END;
} else {
	echo elgg_view('output/url', array(
		'href' => "/plugins/download/{$release->getGUID()}",
		'text' => 'Download plugin',
		'class' => 'elgg-button elgg-button-submit',
	));
}
echo "<div class=\"clearfloat\"></div>";
echo "</div>";

if ($notes) {
	echo "<div class=\"pluginsrepo_description\">";
	echo "<h3>Release notes:</h3>";
	echo autop($notes);
	echo "</div>";
}

echo "<b>Compatible Elgg Version:</b> $release->elgg_version";

if ($release->comments == 'yes') {
	echo elgg_view_comments($release);
}
