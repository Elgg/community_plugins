<?php
/**
 * View for displaying plugin files
 */

echo "<div class='contentWrapper'>";

$release = $vars['entity'];
$project = get_entity($release->container_guid);
$notes = $release->release_notes;
$dl_link = "{$vars['url']}pg/plugins/download/{$release->getGUID()}";
echo "<div id=\"download_action\">";
if ($project->recommended_release_guid && $project->recommended_release_guid != $release->getGUID()) {
	$author = get_entity($project->owner_guid);
	$recommended_link = "{$vars['url']}pg/plugins/{$author->username}/read/{$project->getGUID()}?release={$project->recommended_release_guid}";
	$recommended = get_entity($project->recommended_release_guid);
	echo <<<___END
	<div class="pluginsrepo_description pluginsrepo_warning">
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
	echo <<<___END
	<div class="pluginsrepo_download">
		<a class="download_button" href="$dl_link">Download plugin</a>
	</div>
___END;
}
echo "<div class=\"clearfloat\"></div>";
echo "</div>";

if($notes){
	echo "<div class=\"pluginsrepo_description\">";
	echo "<h3>Release notes:</h3>";
	echo autop($notes);
	echo "</div>";
}

echo "</div>";

if ($release->comments == 'yes') {
	echo elgg_view_comments($release);
}
?>