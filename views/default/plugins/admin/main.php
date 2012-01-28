<div class="contentWrapper">
	<div id="elgg_horizontal_tabbed_nav">

<?php

$selected_tab = $vars['tab'];
if (!$selected_tab) {
	$selected_tab = 'stats';
}

$tabs = array('stats', 'upgrade', 'utilities', 'search');

echo '<ul>';
foreach ($tabs as $tab) {
	$class = '';
	if ($tab == $selected_tab) {
		$class = 'class="selected"';
	}
	$url = elgg_get_site_url() . "plugins/admin/$tab/";
	$title = elgg_echo("plugins:tabs:$tab");
	echo "<li $class><a href=\"$url\">$title</a></li>";
}
echo '</ul>';
?>
	</div>
<?php
echo elgg_view("plugins/admin/$selected_tab");
?>
</div>
