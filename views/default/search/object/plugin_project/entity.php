<?php
/**
 * Elgg plugin browser.
 * Plugin project renderer.
 */

$project = $vars['entity'];
$project_guid = $project->getGUID();
$project_owner = get_entity($project->owner_guid);
$project_owner_username = $project_owner->username;
$tags = $project->tags;
$title = $project->title;
$desc = $project->description;
$summary = $project->summary;
$owner = $vars['entity']->getOwnerEntity();
$license = $vars['entity']->license;
$friendlytime = friendly_time($vars['entity']->time_created);
$dls = get_annotations_sum($vars['entity']->guid,'','','download');
$diggs = count_annotations($vars['entity']->guid, "object", "plugin_project", "plugin_digg");
$usericon = elgg_view(
	"profile/icon", array(
		'entity' => $owner,
		'size' => 'small',
	)
);
if(!$dls) {
	$dls = 0;
}

echo "<div style=\"border:2px solid #efefef;margin-top:4px;\">";
$info = "<span class='downloadsnumber'>{$dls}</span><p class='pluginName'> <a href=\"{$project->getURL()}\">{$title} </a></p>";
if($summary) {
	$info .= "<p class='description'>" . $summary . "</p>";
}
$info .= "<p class=\"owner_timestamp\"><a href=\"{$vars['url']}pg/plugins/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
$info .= "</p>";
$icon = $usericon; //"<a href=\"{$file->getURL()}\">" . elgg_view("plugins/icon", array("mimetype" => $mime, 'thumbnail' => $file->thumbnail, 'plugins_guid' => $file_guid, 'size' => 'small')) . "</a>";
echo elgg_view_listing($icon, $info);

echo "</div>";