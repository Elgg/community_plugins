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
		<?php echo elgg_autop(elgg_echo('plugins:front:intro:text')); ?>
	</div>
<?php
if (elgg_is_logged_in()) {
	echo elgg_view('output/url', array(
		'href' => '/plugins/new/project/' . elgg_get_logged_in_user_entity()->username,
		'text' => elgg_echo('plugins:upload:new'),
		'class' => 'elgg-button elgg-button-submit',
	));
}
?>
</div>
