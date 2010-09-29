<?php
/**
 * Total plugin stats
 */

$num_plugins = number_format((int)get_entities("object", "plugin_project", 0, "", 0, 0, true));
$num_downloads = number_format($CONFIG->site->plugins_download_count);

$num_plugins = "<span>$num_plugins</span>";
$num_downloads = "<span>$num_downloads</span>";
?>
<div class="plugins_download_total">
	<p>
		<?php echo sprintf(elgg_echo('plugins:counter'), $num_plugins, $num_downloads) . '.'; ?>
	</p>
</div>
