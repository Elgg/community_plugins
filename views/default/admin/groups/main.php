<?php
/**
 * Groups administration page
 */

$tab_names = array('categorize', 'combine', 'change_owner', 'delete', 'blog');
$selected_tab = get_input('tab', 'categorize');

$tabs = array();
foreach ($tab_names as $tab) {
	$tabs[] = array(
		'title' => elgg_echo("cg:tabs:$tab"),
		'url' => "admin/groups/main?tab=$tab",
		'selected' => $tab == $selected_tab,
	);
}

echo elgg_view('navigation/tabs', array('tabs' => $tabs, 'class' => 'mbm'));

echo elgg_view("admin/groups/tabs/$selected_tab");
