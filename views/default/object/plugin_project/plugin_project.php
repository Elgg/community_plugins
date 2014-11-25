<?php
$project = $vars['entity'];

$icon = elgg_view_entity_icon($project->getOwnerEntity(), 'tiny', array('use_hover' => false));

$link = elgg_view('output/url', array(
	'encode_text' => true,
	'href' => $project->getURL(), 
	'text' => $project->title, 
));
$friendlytime = elgg_view_friendly_time($project->last_action);
$downloads = $project->getDownloadCount();
$info = "<div class=\"elgg-subtext\">" . elgg_echo('plugins:updatedtime', array($friendlytime, $downloads)) . "</div>";

echo elgg_view_image_block($icon, $link . $info);
