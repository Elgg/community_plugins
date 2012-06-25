<?php


$project = $vars['entity'];


$wwwroot = elgg_get_site_url();

// TODO(evan): Use elgg_view_entity_icon();
$image =<<<ICON
<a href="{$project->getURL()}">
	<img src="{$wwwroot}mod/community_plugins/graphics/icons/archive.gif" alt="" />
</a>
ICON;


$title = elgg_view('output/url', array(
	'text' => $project->title,
	'href' => $project->getURL(),
	'encode_text' => TRUE,
));
$friendlytime = elgg_view_friendly_time($project->time_created);

$body =<<<CONTENT
<h3>{$title}</h3>
<div class="elgg-subtext">{$friendlytime}</div>
CONTENT;

echo elgg_view_image_block($image, $body);