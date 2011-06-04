<?php
/**
 * Total plugin stats
 */

$num_downloads = plugins_get_all_download_count();
$num_downloads = number_format($num_downloads);

$num_plugins = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'plugin_project',
	'count' => true,
));
$num_plugins = number_format($num_plugins);

$num_plugins = "<span>$num_plugins</span>";
$num_downloads = "<span>$num_downloads</span>";
?>
<div class="plugins_download_total">
	<p>
		<?php echo sprintf(elgg_echo('plugins:counter'), $num_plugins, $num_downloads) . '.'; ?>
	</p>
</div>
