<?php
/**
 * Edit release view
 */

if (array_key_exists('release', $vars) && $vars['release'] instanceof PluginRelease) {
	$release = $vars['release'];
	$project = $release->getProject();
	echo elgg_view('input/hidden', array('name' => 'release_guid', 'value' => $release->guid));
}

echo elgg_view('plugins/forms/release_details_segment', array('release' => $release, 'project' => $project));

?>

<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>

<?php
elgg_clear_sticky_form('community_plugins');