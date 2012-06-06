<?php
/** @var PluginProject */
$project = $vars['entity'];

$release = $vars['release'];

// get required variables
$project_owner = $project->getOwnerEntity();
$updated = elgg_view_friendly_time($project->getLatestRelease()->time_created);

?>

<h2>
<?php 
	echo elgg_view('output/url', array(
		'href' => $project->getURL(),
		'text' => $project->title,
		'encode_text' => TRUE,
		'is_trusted' => TRUE,
	));
?>
</h2>
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
?>
<?php echo autop($project->description); ?>
<?php echo elgg_view('plugins/recommend', array('project' => $project)); ?>
<?php

if ($release) {
	echo elgg_view_entity($release);
}
