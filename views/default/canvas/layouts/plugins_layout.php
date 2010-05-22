<?php
/**
 * Elgg plugins layout
 */

?>
<div id="plugins_sidebar">
	<?php echo $vars['area2']; ?>
</div>
<div id="plugins_main">
	<?php echo $vars['area1']; ?>
</div>

<?php
if (isset($vars['area3'])) {
	echo '<div id="plugins_bottom">';
	echo $vars['area3'];
	echo '</div>';
}
