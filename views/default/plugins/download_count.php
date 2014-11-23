<?php
/**
 * Total plugin stats for main page
 */

namespace Elgg\CommunityPlugins;

$num_downloads = get_all_download_count();
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
		<?php echo elgg_echo('plugins:counter', array($num_plugins, $num_downloads)) . '.'; ?>
	</p>
</div>
