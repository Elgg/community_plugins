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
$downloads = $project->getDownloadCount();
$friendlytime = elgg_view_friendly_time($project->time_created);
$iconpath = elgg_get_site_url() . 'mod/community_plugins/graphics/icons';
$owner = $project->getOwnerEntity();
$recommends = $project->countAnnotations('plugin_digg');
$summary = $project->summary;
$updated = elgg_view_friendly_time($project->getLatestRelease()->time_created);
$image = elgg_view_entity_icon($owner, 'small');

$info = "<div class='pluginName'> $link";
$info .= "<span class=\"info_item\"><img src=\"$iconpath/updated.png\" alt=\"Updated\" title=\"Updated\">$updated</span>";
$info .= "<span class=\"info_item\"><img src=\"$iconpath/recommended.png\" alt=\"Recommendations\" title=\"Recommendations\">$recommends</span>";
$info .= "<span class=\"info_item\"><img src=\"$iconpath/downloaded.png\" alt=\"Downloads\" title=\"Downloads\">$downloads</span>";
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
