<?php
/**
 * Upload new release view
 */
echo elgg_view('plugins/forms/release_details_segment', $vars);

?>

<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>
