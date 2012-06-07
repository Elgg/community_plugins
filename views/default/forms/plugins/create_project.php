<?php
echo elgg_view('plugins/forms/project_details_segment', $vars);
echo elgg_view('plugins/forms/release_details_segment', $vars);

if (isset($vars['container_guid'])) {
	echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $vars['container_guid']));
}

if (isset($vars['entity'])) {
	echo elgg_view('input/hidden', array('name' => 'plugins_guid', 'value' => $vars['entity']->guid));
}

?>

<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo("save"))); ?>
</div>