<?php
/**
 * Admin page for plugin repository
 */

admin_gatekeeper();
set_context('admin');

$tab = get_input("tab");

$title = elgg_echo('plugins:admin');

$content = elgg_view_title($title);
$content .= elgg_view('plugins/admin/main', array("tab" => $tab));

$body = elgg_view_layout("two_column_left_sidebar", '', $content);

page_draw($title, $body);
