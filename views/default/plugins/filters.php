<?php
/**
 * Filters for search
 */

global $CONFIG;
$url = elgg_get_site_url() . 'plugins';
$settings = $vars['settings'];

if (isset($settings['filter']) && ($settings['filter'] == 'multiple')) {
	$label_prefix ='';
} else {
	$label_prefix = elgg_echo('plugins:filters:or');
}
$prefix = '';

if (!isset($settings['filter']) || ($settings['filter'] != 'multiple')) {
	elgg_load_js('elgg.communityPlugins.filters');
}

?>

<div id="plugin_filters">

	<div class="plugins_sidebar_box">

	<form method="get" name="plugin_search_form" id="plugin_search_form" action="<?php echo elgg_get_site_url(); ?>plugins/search">
		<h3 class="filter_title"><?php echo elgg_echo('plugins:filters:title'); ?></h3>
		<br />

		<?php if (is_array($settings['category']) && in_array('enabled', $settings['category'])) : ?>
			<?php $classtext = in_array('multiple', $settings['category']) ? 'class="input-select multiselect" multiple="multiple"' : 'class="input-select"'; ?>
			<div class="filter_fields">
				<div class="filter_label"><?php echo $prefix . elgg_echo('plugins:filters:category'); ?></div>
				<div>
					<select name="f[c][]" <?php echo $classtext; ?>>
					<?php foreach ($vars['categories'] as $key => $category) :?>
						<option value="<?php echo $key; ?>" <?php echo (is_array($vars['current_values']['c']) && in_array($key, $vars['current_values']['c'])) ? 'selected="selected"' : ''; ?>><?php echo $category; ?></option>
					<?php endforeach; ?>
					</select>
				</div>
			</div>
			<?php $prefix = $label_prefix; ?>
		<?php endif; ?>

		<?php if (is_array($settings['version']) && in_array('enabled', $settings['version'])) : ?>
			<?php $classtext = in_array('multiple', $settings['version']) ? 'class="input-select multiselect" multiple="multiple"' : 'class="input-select"'; ?>
			<div class="filter_fields">
				<div class="filter_label"><?php echo $prefix . elgg_echo('plugins:filters:version'); ?></div>
				<div>
					<select name="f[v][]" <?php echo $classtext; ?>>
					<?php foreach ($vars['versions'] as $version) :?>
						<option value="<?php echo $version; ?>" <?php echo (is_array($vars['current_values']['v']) && in_array($version, $vars['current_values']['v'])) ? 'selected="selected"' : ''; ?>><?php echo $version; ?></option>
					<?php endforeach; ?>
					</select>
				</div>
			</div>
			<?php $prefix = $label_prefix; ?>
		<?php endif; ?>

		<?php if (is_array($settings['licence']) && in_array('enabled', $settings['licence'])) : ?>
			<?php $classtext = in_array('multiple', $settings['licence']) ? 'class="input-select multiselect" multiple="multiple"' : 'class="input-select"'; ?>
			<div class="filter_fields">
				<div class="filter_label"><?php echo $prefix . elgg_echo('plugins:filters:licence'); ?></div>
				<div>
					<select name="f[l][]" <?php echo $classtext; ?>>
					<?php foreach ($vars['licences'] as $key => $licence) :?>
						<option value="<?php echo $key; ?>" <?php echo (is_array($vars['current_values']['l']) && in_array($key, $vars['current_values']['l'])) ? 'selected="selected"' : ''; ?>><?php echo $licence; ?></option>
					<?php endforeach; ?>
					</select>
				</div>
			</div>
			<?php $prefix = $label_prefix; ?>
		<?php endif; ?>

		<?php if (is_array($settings['text']) && in_array('enabled', $settings['text'])) : ?>
			<div class="filter_fields">
				<div class="filter_label"><?php echo $prefix . elgg_echo('plugins:filters:text'); ?></div>
				<div>
					<input type="text" name="f[t]" value="<?php echo $vars['current_values']['t']; ?>" class="input-text"/>
				</div>
			</div>
			<?php $prefix = $label_prefix; ?>
		<?php endif; ?>

		<?php if (isset($settings['screenshot'])) : ?>
			<div class="filter_fields">
				<div class="filter_label"><?php echo $prefix . elgg_echo('plugins:filters:screenshot:label'); ?></div>
				<div>
					<input type="checkbox" name="f[s]" <?php echo (isset($vars['current_values']['s'])) ? 'checked="checked"' : ''; ?>/>
					<?php echo elgg_echo('plugins:filters:screenshot'); ?>
				</div>
			</div>
			<?php $prefix = $label_prefix; ?>
		<?php endif; ?>


		<div class="search_fields">
			<input type="submit" class='search_plugins' name="sb" value="Search" />
			<button type="button" id="clear_search" class='clear_search' name="clear">Clear values</button>
		</div>
	</form>

	</div>
</div>