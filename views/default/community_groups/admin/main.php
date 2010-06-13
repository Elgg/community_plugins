<div class="contentWrapper">
	<div id="elgg_horizontal_tabbed_nav">

<?php

$selected_tab = $vars['tab'];

$tabs = array('combine', 'delete');

echo '<ul>';
foreach ($tabs as $tab) {
	$class = '';
	if ($tab == $selected_tab) {
		$class = 'class="selected"';
	}
	$url = "{$CONFIG->wwwroot}pg/groupsadmin/$tab/";
	$title = elgg_echo("cg:tabs:$tab");
	echo "<li $class><a href=\"$url\">$title</a></li>";
}
echo '</ul>';
?>
	</div>
<?php
echo elgg_view("community_groups/admin/tabs/$selected_tab");
?>
</div>
