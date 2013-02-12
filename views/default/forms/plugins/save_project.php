<?php
/**
 * Edit project view
 */

if (array_key_exists('project', $vars)
&& $vars['project'] instanceof ElggObject
&& $vars['project']->getSubtype() == 'plugin_project') {
		$project = $vars['project'];
		echo elgg_view('input/hidden', array('name' => 'plugins_guid', 'value' => $project->guid));
}

echo elgg_view('plugins/forms/project_details_segment', array('project' => $project)); 

?>

<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>

<?php
elgg_clear_sticky_form('community_plugins');