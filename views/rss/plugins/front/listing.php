<?php
if ($vars['plugins']) {
	foreach ($vars['plugins'] as $plugin) {
		echo elgg_view_entity($plugin);
	}
}
?>
