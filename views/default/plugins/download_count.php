<?php
$num_plugins = (int)$vars['plugin_count'];
$num_downloads = (int)$vars['download_count'];

$num_plugins = "<span>{$num_plugins}</span>";
$num_downloads = "<span>{$num_downloads}</span>";
?>
<p>
<?php echo sprintf(elgg_echo('plugins:counter'), $num_plugins, $num_downloads) . '.'; ?>
</p>
