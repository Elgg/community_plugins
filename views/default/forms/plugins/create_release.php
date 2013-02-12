<?php
/**
 * Upload new release view
 */

if (array_key_exists('project', $vars) && $vars['project'] instanceof ElggObject) {
	$project_guid = $vars['project']->getGUID();
}

echo elgg_view('plugins/forms/release_details_segment', $vars);
echo elgg_view("input/hidden", array("name" => "guid", "value" => $project_guid));

?>

<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>

<?php
elgg_clear_sticky_form('community_plugins');