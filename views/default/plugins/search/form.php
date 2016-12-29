<?php 

global $CONFIG;
$url = elgg_get_site_url() . 'plugins';
$settings = $vars['settings'];

elgg_load_css('jquery.chosen');
elgg_require_js('chosen/chosen.jquery');
elgg_require_js('elgg/community_plugins/plugins');

if (isset($settings['filter']) && ($settings['filter'] == 'multiple')) {
	$label_prefix = '';
} else {
	$label_prefix = elgg_echo('plugins:filters:or');
}
$prefix = '';

if (!isset($settings['filter']) || ($settings['filter'] != 'multiple')) {
	elgg_require_js('elgg/community_plugins/filters');
}

$build_select = function ($settings_key, $vars_key, $values_key) use ($settings, $vars) {
	$select_attrs = [
		'name' => "f[$values_key][]",
		'class' => ['input-select'],
		'data-placeholder' => elgg_echo("plugins:placeholder:$vars_key"),
	];
	if (in_array('multiple', $settings[$settings_key])) {
		$select_attrs['class'][] = 'multiselect';
		$select_attrs['multiple'] = true;
	}

	$options = array_map(
		function ($key, $category) use ($vars, $values_key) {
			return elgg_format_element('option', [
				'value' => $key,
				'selected' => isset($vars['current_values'][$values_key])
								&& in_array($key, $vars['current_values'][$values_key]),
			], $category);
		},
		array_keys($vars[$vars_key]),
		$vars[$vars_key]
	);
	return elgg_format_element('select', $select_attrs, implode('', $options));
};

?>
<form method="get" name="plugin_search_form" id="plugin_search_form" action="<?php echo elgg_get_site_url(); ?>plugins/search">
	<?php if (is_array($settings['category']) && in_array('enabled', $settings['category'])) : ?>
		<div class="filter_fields">
			<div class="filter_label"><?= $prefix . elgg_echo('plugins:filters:category'); ?></div>
			<div>
				<?= $build_select('category', 'categories', 'c'); ?>
			</div>
		</div>
		<?php $prefix = $label_prefix; ?>
	<?php endif; ?>

	<?php if (is_array($settings['version']) && in_array('enabled', $settings['version'])) : ?>
		<div class="filter_fields">
			<div class="filter_label"><?= $prefix . elgg_echo('plugins:filters:version'); ?></div>
			<div>
				<?= $build_select('version', 'versions', 'v'); ?>
			</div>
		</div>
		<?php $prefix = $label_prefix; ?>
	<?php endif; ?>

	<?php if (is_array($settings['licence']) && in_array('enabled', $settings['licence'])) : ?>
		<div class="filter_fields">
			<div class="filter_label"><?= $prefix . elgg_echo('plugins:filters:licence'); ?></div>
			<div>
				<?= $build_select('licence', 'licences', 'l'); ?>
			</div>
		</div>
		<?php $prefix = $label_prefix; ?>
	<?php endif; ?>

	<?php if (is_array($settings['text']) && in_array('enabled', $settings['text'])) : ?>
		<div class="filter_fields">
			<div class="filter_label"><?= $prefix . elgg_echo('plugins:filters:text'); ?></div>
			<div>
				<?= elgg_format_element('input', [
					'type' => 'text',
					'name' => 'f[t]',
					'value' => isset($vars['current_values']['t']) ? $vars['current_values']['t'] : '',
					'class' => 'input-text',
					'placeholder' => elgg_echo('plugins:placeholder:keyword'),
				]); ?>
			</div>
		</div>
		<?php $prefix = $label_prefix; ?>
	<?php endif; ?>

	<?php if (isset($settings['screenshot'])) : ?>
		<div class="filter_fields">
			<div class="filter_label"><?php echo $prefix . elgg_echo('plugins:filters:screenshot:label'); ?></div>
			<div>
				<?= elgg_format_element('input', [
					'type' => 'checkbox',
					'name' => 'f[s]',
					'checked' => isset($vars['current_values']['s']),
				]); ?>
				<?php echo elgg_echo('plugins:filters:screenshot'); ?>
			</div>
		</div>
		<?php $prefix = $label_prefix; ?>
	<?php endif; ?>

	<div class="search_fields">
		<?php echo elgg_view('input/submit', array('name' => 'sb', 'value' => 'Search')); ?>
		<?php echo elgg_view('input/reset', array('name' => 'clear', 'id' => 'clear_search')); ?>
	</div>
</form>
