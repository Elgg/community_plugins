<?php 
	global $CONFIG;
	$serialized_settings = elgg_get_plugin_setting('search-settings', 'community_plugins');
	$settings = unserialize($serialized_settings);
	if (!is_array($settings)) {
		$settings = array();
	}
?>
<ul class="elgg-input-checkboxes">
	<li>
		<label>
			<input type="checkbox" name="search_settings[sort]" class="elgg-input-checkbox" value="enabled" 
				<?php echo (isset($settings['sort']) && $settings['sort'] == 'enabled') ? 'checked="checked"' : ''; ?>/>
			<?php echo elgg_echo ('plugins:settings:sort:label'); ?>
		</label>
	</li>
	<li>
		<label>
			<input type="checkbox" name="search_settings[filter]" class="elgg-input-checkbox" value="multiple" 
				<?php echo (isset($settings['filter']) && $settings['filter'] == 'multiple') ? 'checked="checked"' : ''; ?>/>
			<?php echo elgg_echo ('plugins:settings:filter:multiple:label'); ?>
		</label>
	</li>
</ul>
<hr />
<ul class="elgg-input-checkboxes">
	<li>
		<label>
			<input type="checkbox" name="search_settings[category][]" class="elgg-input-checkbox" value="enabled" 
				<?php echo (is_array($settings['category']) && in_array('enabled', $settings['category'])) ? 'checked="checked"' : ''; ?>/>
			<?php echo elgg_echo ('plugins:settings:filter:category:label'); ?>
		</label>
		<ul class="elgg-input-checkboxes">
			<li>
				<label>
					<input type="checkbox" name="search_settings[category][]" class="elgg-input-checkbox" value="multiple" 
						<?php echo (is_array($settings['category']) && in_array('multiple', $settings['category'])) ? 'checked="checked"' : ''; ?>/>
					<?php echo elgg_echo ('plugins:settings:filter:category:multiple'); ?>
				</label>
			</li>
		</ul>
	</li>
	<li>
		<label>
			<input type="checkbox" name="search_settings[version][]" class="elgg-input-checkbox" value="enabled" 
				<?php echo (is_array($settings['version']) && in_array('enabled', $settings['version'])) ? 'checked="checked"' : ''; ?>/>
			<?php echo elgg_echo ('plugins:settings:filter:version:label'); ?>
		</label>
		<ul class="elgg-input-checkboxes">
			<li>
				<label>
					<input type="checkbox" name="search_settings[version][]" class="elgg-input-checkbox" value="multiple" 
						<?php echo (is_array($settings['version']) && in_array('multiple', $settings['version'])) ? 'checked="checked"' : ''; ?>/>
					<?php echo elgg_echo ('plugins:settings:filter:version:multiple'); ?>
				</label>
			</li>
		</ul>
	</li>
	<li>
		<label>
			<input type="checkbox" name="search_settings[licence][]" class="elgg-input-checkbox" value="enabled" 
				<?php echo (is_array($settings['licence']) && in_array('enabled', $settings['licence'])) ? 'checked="checked"' : ''; ?>/>
			<?php echo elgg_echo ('plugins:settings:filter:licence:label'); ?>
		</label>
		<ul class="elgg-input-checkboxes">
			<li>
				<label>
					<input type="checkbox" name="search_settings[licence][]" class="elgg-input-checkbox" value="multiple" 
						<?php echo (is_array($settings['licence']) && in_array('multiple', $settings['licence'])) ? 'checked="checked"' : ''; ?>/>
					<?php echo elgg_echo ('plugins:settings:filter:licence:multiple'); ?>
				</label>
			</li>
		</ul>
	</li>
	<li>
		<label>
			<input type="checkbox" name="search_settings[text][]" class="elgg-input-checkbox" value="enabled" 
				<?php echo (is_array($settings['text']) && in_array('enabled', $settings['text'])) ? 'checked="checked"' : ''; ?>/>
			<?php echo elgg_echo ('plugins:settings:filter:text:label'); ?>
		</label>
		<ul class="elgg-input-checkboxes">
			<li>
				<label>
					<input type="checkbox" name="search_settings[text][]" class="elgg-input-checkbox" value="author-name" 
						<?php echo (is_array($settings['text']) && in_array('author-name', $settings['text'])) ? 'checked="checked"' : ''; ?>/>
					<?php echo elgg_echo ('plugins:settings:filter:text:author:name'); ?>
				</label>
			</li>
			<li>
				<label>
					<input type="checkbox" name="search_settings[text][]" class="elgg-input-checkbox" value="author-username" 
						<?php echo (is_array($settings['text']) && in_array('author-username', $settings['text'])) ? 'checked="checked"' : ''; ?>/>
					<?php echo elgg_echo ('plugins:settings:filter:text:author:username'); ?>
				</label>
			</li>
			<li>
				<label>
					<input type="checkbox" name="search_settings[text][]" class="elgg-input-checkbox" value="summary" 
						<?php echo (is_array($settings['text']) && in_array('summary', $settings['text'])) ? 'checked="checked"' : ''; ?>/>
					<?php echo elgg_echo ('plugins:settings:filter:text:summary'); ?>
				</label>
			</li>
			<li>
				<label>
					<input type="checkbox" name="search_settings[text][]" class="elgg-input-checkbox" value="tags" 
						<?php echo (is_array($settings['text']) && in_array('tags', $settings['text'])) ? 'checked="checked"' : ''; ?>/>
					<?php echo elgg_echo ('plugins:settings:filter:text:tags'); ?>
				</label>
			</li>
		</ul>
	</li>
	<li>
		<label>
			<input type="checkbox" name="search_settings[screenshot]" class="elgg-input-checkbox" value="enabled" 
				<?php echo (isset($settings['screenshot']) && $settings['screenshot'] == 'enabled') ? 'checked="checked"' : ''; ?>/>
			<?php echo elgg_echo ('plugins:settings:filter:screenshot:label'); ?>
		</label>
	</li>
</ul>
<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>
