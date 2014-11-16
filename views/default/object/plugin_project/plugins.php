<?php
/** @var PluginProject $project */
$project = $vars['entity'];

/** @var PluginRelease $release */
$release = $vars['release'];

// get required variables
$project_owner = $project->getOwnerEntity();

$updated = elgg_view_friendly_time($project->getLatestRelease()->time_created);

elgg_register_menu_item('title', array(
	'name' => 'download',
	'href' => "/plugins/download/$release->guid",
	'text' => elgg_echo('plugins:download:version', array($release->version)),
	'link_class' => 'elgg-button elgg-button-' . ($release && $release->isRecommendedRelease() ? 'submit' : 'delete'),
	'encode_text' => TRUE,
	'confirm' => $release && $release->isRecommendedRelease() ? false : elgg_echo('plugins:release:version_warning'),
));

if (elgg_is_logged_in() && !$project->isDugg()) {
	elgg_register_menu_item('title', array(
		'name' => 'recommend',
		'link_class' => 'elgg-button elgg-button-action',
		'href' => "/action/plugins/recommend?guid={$project->guid}",
		'is_action' => TRUE,
		'text' => elgg_echo('Recommend'),
	));
}

echo elgg_view('object/plugin_project/warning', array('entity' => $project));

echo elgg_view('object/plugin_project/screenshots', array('entity' => $project));

?>


<h4>
	<?php echo elgg_view('output/text', array('value' => $project->summary)); ?>
</h4>
<?php

$image = elgg_view_entity_icon($project_owner, 'tiny');
$author_link = elgg_view('output/url', array(
	'href' => "/plugins/developer/$project_owner->username",
	'text' => $project_owner->name,
	'encode_text' => TRUE,
));
$tags = elgg_view('output/tags', array('value' => $project->tags));

$by_author = elgg_echo('plugins:author:byline', array($author_link));
$last_updated = elgg_echo('plugins:last:updated', array($updated));

$body =<<<DETAILS
	<div class="elgg-subtext">$by_author</div>
	<div class="elgg-subtext">$last_updated</div>
DETAILS;

echo elgg_view_image_block($image, $body);
?>

<div class="elgg-output">
	<?php echo elgg_autop($project->description); ?>
</div>

<?php

if ($release) {
	echo elgg_view_entity($release);
}
