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
	'text' => "Download $release->version",
	'class' => 'elgg-button elgg-button-' . ($release && $release->isRecommendedRelease() ? 'submit' : 'delete'),
	'encode_text' => TRUE,
	'confirm' => $release && $release->isRecommendedRelease() ? false : 'Warning: The author recommends using a different release of this plugin! Do you still want to download this release?',
));

if (elgg_is_logged_in() && !$project->isDugg()) {
	elgg_register_menu_item('title', array(
		'name' => 'recommend',
		'class' => 'elgg-button elgg-button-action',
		'href' => "/action/plugins/recommend?guid={$project->guid}",
		'is_action' => TRUE,
		'text' => elgg_echo('Recommend'),
	));
}

echo elgg_view('page/layouts/content/header', array('title' => "$project->title for Elgg $release->elgg_version"));

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

$body =<<<DETAILS
	<div class="elgg-subtext">by $author_link</div>
	<div class="elgg-subtext">Last updated $updated</div>
DETAILS;

echo elgg_view_image_block($image, $body);
echo autop($project->description);

if ($release) {
	echo elgg_view_entity($release);
}
