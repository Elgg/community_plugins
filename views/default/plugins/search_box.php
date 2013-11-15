<?php
/**
 * Search box used throughout plugin repository
 */

$category = 'all';
if (isset($vars['category'])) {
	$category = $vars['category'];
}

$search_text = elgg_echo('plugins:search:instruct');
if (get_input('q')) {
	$search_text = get_input('q');
}
?>
<div class="plugins_search_box">
	<?php $search_url = elgg_get_site_url() . "search"; ?>
	<form action="<?php echo $search_url; ?>" method="get" id="plugins_search_form">
		<input type="hidden" name="entity_subtype" value="plugin_project" />
		<input type="hidden" name="entity_type" value="object" />
		<input type="hidden" name="search_type" value="entities" />
		<input type="text" name="q" value="<?php echo htmlspecialchars($search_text); ?>" placeholder="<?php echo elgg_echo('search'); ?>" />
		<label for="category"><?php echo elgg_echo('plugins:search:choose'); ?>:</label>
		<select name="category">
			<option value="all"><?php echo elgg_echo('plugins:cat:all'); ?></option>
<?php
foreach(elgg_get_config('plugincats') as $value => $option) {
	if ($value == $category) {
		$selected = 'selected="selected"';
	} else {
		$selected = '';
	}

	echo "<option value=\"{$value}\" $selected>{$option}</option>";
}
?>
		</select>
		<input type="submit" name="submit" value="<?php echo elgg_echo('search'); ?>" class="plugins_search_submit" />
</form>
</div>

