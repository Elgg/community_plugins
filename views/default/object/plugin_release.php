<?php
/**
 * Plugin release
 *
 */

$release = $vars['entity'];
$notes = $release->release_notes;

if ($notes) {
	echo "<div class=\"elgg-output\">";
	echo "<h3>" . elgg_echo('plugins:edit:label:release_notes') . ":</h3>";
	echo elgg_autop($notes);
	echo "</div>";
}

if ($release->comments == 'yes') {
	echo elgg_view_comments($release);
}
