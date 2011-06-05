<?php
/**
 * Elgg plugins layout
 *
 * @uses $vars['area1'] Main content area
 * @uses $vars['area2'] Sidebar
 * @uses $vars['area3'] Optional footer
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
