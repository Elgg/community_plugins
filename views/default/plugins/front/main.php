<?php
/**
 * Front page main area - welcome and search
 */
?>
<div id="plugins_front_welcome">
	<h2><?php echo elgg_echo('plugins:front:welcome'); ?>.</h2>
	<?php echo elgg_view('plugins/download_count'); ?>
	<h3><?php echo elgg_echo('plugins:front:intro:title'); ?></h3>
	<div id="plugins_welcome_text">
		<?php echo autop(elgg_echo('plugins:front:intro:text')); ?>
	</div>
<?php
if (isloggedin()) {
	$url = $vars['url'] . 'pg/plugins/new/project/' . get_loggedin_user()->username;
?>
	<a class="upload_plugin" href="<?php echo $url; ?>"><?php echo elgg_echo('plugins:upload:new'); ?></a>
<?php
}
?>
</div>
