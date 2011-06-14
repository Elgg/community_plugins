<?php
global $CONFIG;
$title = elgg_echo("plugins:listing:{$vars['type']}");
?>
<div class="plugins_front_listing">
	<h2><?php echo $title; ?></h2>
<?php
$back_color = 'odd';
foreach ($vars['plugins'] as $plugin) {

	echo "<div class=\"small_plugin_view {$back_color}\">";
	echo elgg_view_entity($plugin);
	echo "</div>";

	if ($back_color == 'odd') {
		$back_color = 'even';
	} else {
		$back_color = 'odd';
	}
}
?>
	<div class="browse_more">
		<a class="upload_plugin" href="<?php echo $CONFIG->wwwroot?>pg/plugins/all?sort=<?php echo $vars['type']; ?>">
			<?php echo elgg_echo("plugins:browse_more:{$vars['type']}"); ?>
		</a>
	</div>
</div>
