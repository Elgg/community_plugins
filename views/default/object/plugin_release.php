<?php
/**
 * Plugin release
 * 
 */

$release = $vars['entity'];
$notes = $release->release_notes;

if ($notes) {
	echo "<div class=\"pluginsrepo_description\">";
	echo "<h3>Release notes:</h3>";
	echo autop($notes);
	echo "</div>";
}

if ($release->comments == 'yes') {
	echo elgg_view_comments($release);
}
