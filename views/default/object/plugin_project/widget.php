<?php


$project = $vars['entity'];


$wwwroot = elgg_get_site_url();
$image =<<<ICON
<a href="{$project->getURL()}">
	<img src="{$wwwroot}mod/community_plugins/graphics/icons/archive.gif" />
</a>
ICON;


$title = elgg_view('output/url', array(
	'text' => $plugin->title,
	'href' => $project->getURL(),
	'encode_text' => TRUE,
));
$friendlytime = elgg_view_friendly_time($project->time_created);

$body =<<<CONTENT
<div class="pluginsrepo_listview_title">
	<p class="filerepo_title">{$title}</p>
</div>
<div class="pluginsrepo_listview_date">
	<p class="filerepo_timestamp">
		<small>{$friendlytime}</small>
	</p>
</div>
CONTENT;

echo elgg_view_image_block($image, $body);