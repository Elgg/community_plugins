<?php
/**
 * Front page for plugin repository
 */
global $CONFIG;

elgg_set_context('plugin_project');

ob_start();
?>
<div class="elgg-plugins-layout clearfix">
	<div class="elgg-col elgg-col-1of3 elgg-plugins-intro">
		<?= elgg_view('plugins/front/main') ?>
	</div>
	<div class="elgg-col elgg-col-2of3 elgg-plugins-search">
		<?=
		elgg_view('plugins/filters', [
			'categories' => $CONFIG->plugincats,
			'versions' => $CONFIG->elgg_versions,
			'licences' => $CONFIG->gpllicenses,
		]);
		?>
	</div>
</div>
<?= elgg_view('plugins/front/bottom'); ?>

<?php
$welcome = ob_get_clean();

$body = elgg_view_layout('one_column', [
	'content' => $welcome,
	'sidebar' => false,
]);

echo elgg_view_page(elgg_echo("plugins:all"), $body);
