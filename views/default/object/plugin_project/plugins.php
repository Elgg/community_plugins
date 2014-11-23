<?php
/** @var PluginProject $project */
$project = $vars['entity'];

elgg_require_js('elgg/community_plugins/plugin_page');

/** @var PluginRelease $release */
$release = $vars['release'];

// get required variables
$project_owner = $project->getOwnerEntity();

$updated = elgg_view_friendly_time($project->getLatestRelease()->time_created);

if ($project->canEdit()) {
	elgg_register_menu_item('title', array(
		'name' => 'edit',
		'link_class' => 'elgg-button elgg-button-action',
		'href' => "plugins/edit/project/{$project->guid}",
		'text' => elgg_echo('edit'),
	));
}

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

$screenshots = elgg_view('object/plugin_project/screenshots', array('entity' => $project));

$stable_downloads = elgg_view('object/plugin_project/release_table', array('entity' => $project, 'stable' => true));
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

$body = <<<DETAILS
	<div class="elgg-subtext">$by_author</div>
	<div class="elgg-subtext">$last_updated</div>
DETAILS;

echo elgg_view_image_block($image, $body);

echo $screenshots;

echo $stable_downloads;
?>

<div class="elgg-output">
<?php echo elgg_autop($project->description); ?>
</div>
