<?php 
	global $CONFIG;
	$serialized_settings = elgg_get_plugin_setting('search-settings', 'community_plugins');
	$settings = unserialize($serialized_settings);
	if (!is_array($settings)) {
		$settings = array();
	}
?>

<p>
	<label>
		<?php echo elgg_echo ('plugins:settings:sort:label'); ?>
		<input type="checkbox" name="search_settings[sort]" class="input-checkboxes" value="enabled" 
			<?php echo (isset($settings['sort']) && $settings['sort'] == 'enabled') ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<p>
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:multiple:label'); ?>
		<input type="checkbox" name="search_settings[filter]" class="input-checkboxes" value="multiple" 
			<?php echo (isset($settings['filter']) && $settings['filter'] == 'multiple') ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<hr />
<p>
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:category:label'); ?>
		<input type="checkbox" name="search_settings[category][]" class="input-checkboxes" value="enabled" 
			<?php echo (is_array($settings['category']) && in_array('enabled', $settings['category'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<p class="sub-option">
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:category:multiple'); ?>
		<input type="checkbox" name="search_settings[category][]" class="input-checkboxes" value="multiple" 
			<?php echo (is_array($settings['category']) && in_array('multiple', $settings['category'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<br />
<p>
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:version:label'); ?>
		<input type="checkbox" name="search_settings[version][]" class="input-checkboxes" value="enabled" 
			<?php echo (is_array($settings['version']) && in_array('enabled', $settings['version'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<p class="sub-option">
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:version:multiple'); ?>
		<input type="checkbox" name="search_settings[version][]" class="input-checkboxes" value="multiple" 
			<?php echo (is_array($settings['version']) && in_array('multiple', $settings['version'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<br />
<p>
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:licence:label'); ?>
		<input type="checkbox" name="search_settings[licence][]" class="input-checkboxes" value="enabled" 
			<?php echo (is_array($settings['licence']) && in_array('enabled', $settings['licence'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<p class="sub-option">
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:licence:multiple'); ?>
		<input type="checkbox" name="search_settings[licence][]" class="input-checkboxes" value="multiple" 
			<?php echo (is_array($settings['licence']) && in_array('multiple', $settings['licence'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<br />
<p>
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:text:label'); ?>
		<input type="checkbox" name="search_settings[text][]" class="input-checkboxes" value="enabled" 
			<?php echo (is_array($settings['text']) && in_array('enabled', $settings['text'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<p class="sub-option">
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:text:author:name'); ?>
		<input type="checkbox" name="search_settings[text][]" class="input-checkboxes" value="author-name" 
			<?php echo (is_array($settings['text']) && in_array('author-name', $settings['text'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<p class="sub-option">
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:text:author:username'); ?>
		<input type="checkbox" name="search_settings[text][]" class="input-checkboxes" value="author-username" 
			<?php echo (is_array($settings['text']) && in_array('author-username', $settings['text'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<p class="sub-option">
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:text:summary'); ?>
		<input type="checkbox" name="search_settings[text][]" class="input-checkboxes" value="summary" 
			<?php echo (is_array($settings['text']) && in_array('summary', $settings['text'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<p class="sub-option">
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:text:tags'); ?>
		<input type="checkbox" name="search_settings[text][]" class="input-checkboxes" value="tags" 
			<?php echo (is_array($settings['text']) && in_array('tags', $settings['text'])) ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<br />
<p>
	<label>
		<?php echo elgg_echo ('plugins:settings:filter:screenshot:label'); ?>
		<input type="checkbox" name="search_settings[screenshot]" class="input-checkboxes" value="enabled" 
			<?php echo (isset($settings['screenshot']) && $settings['screenshot'] == 'enabled') ? 'checked="checked"' : ''; ?>/>
	</label>
</p>
<br />
<p>
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</p>
