<?php
$search_text = elgg_echo('plugins:search:instruct');
?>
<div class="plugins_search_box">
	<?php $search_url = "{$vars['url']}pg/search"; ?>
	<form action="<?php echo $search_url; ?>" method="get" id="plugins_search_form">
		<input type="hidden" name="entity_subtype" value="plugin_project" />
		<input type="hidden" name="entity_type" value="object" />
		<input type="hidden" name="search_type" value="entities" />
		<input type="text" name="q" value="<?php echo $search_text; ?>" onclick="if (this.value) { this.value='' }" />
		<label for="category"><?php echo elgg_echo('plugins:search:choose'); ?>:</label>
		<select name="category">
			<option value="all"><?php echo elgg_echo('plugins:cat:all'); ?></option>
<?php
foreach($vars['config']->plugincats as $value => $option) {
	echo "<option value=\"{$value}\">{$option}</option>";
}
?>
		</select>
		<input type="submit" name="submit" value="<?php echo elgg_echo('search'); ?>" class="plugins_search_submit" />
</form>
</div>

