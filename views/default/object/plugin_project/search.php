<?php
/**
 * @var PluginProject
 */
$project = $vars['entity'];

$link = elgg_view('output/url', array(
	'href' => $project->getURL(),
	'text' => $project->title,
	'encode_text' => TRUE,
));

$created = date('d M, Y', $project->time_created);
$download_count = $project->getDownloadCount();
$friendlytime = elgg_view_friendly_time($project->time_created);
$iconpath = elgg_get_site_url() . 'mod/community_plugins/graphics/icons';
$owner = $project->getOwnerEntity();
$recommends = $project->countAnnotations('plugin_digg');
$summary = $project->summary;
if ($project->getLatestRelease()->time_created) {
	$updated_time = elgg_view_friendly_time($project->getLatestRelease()->time_created);
}
else {
	$updated_time = elgg_view_friendly_time($project->time_created);
}
$image = elgg_view_entity_icon($owner, 'small');

$updated = elgg_echo('plugins:updated');
$recommendations = elgg_echo('plugins:recommendations');
$downloads = elgg_echo('plugins:downloads');

$info = "<div class='pluginName'> $link";
$info .= "<span class=\"info_item\"><img src=\"$iconpath/updated.png\" alt=\"$updated\" title=\"$updated\">$updated_time</span>";
$info .= "<span class=\"info_item\"><img src=\"$iconpath/recommended.png\" alt=\"$recommendations\" title=\"$recommendations\">$recommends</span>";
$info .= "<span class=\"info_item\"><img src=\"$iconpath/downloaded.png\" alt=\"$downloads\" title=\"$downloads\">$download_count</span>";
$info .= '</div>';
if ($summary) {
	$info .= "<p class='description'>" . $summary . "</p>";
}

$user_link = elgg_view('output/url', array(
	'text' => $owner->name,
	'href' => "/plugins/developer/{$owner->username}",
	'encode_text' => TRUE,
));
$info .= "<p class=\"owner_timestamp\">$user_link $created ($friendlytime)</p>";

echo elgg_view_image_block($image, $info);
