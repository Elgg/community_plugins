<?php
/**
 * Elgg plugin search
 */

set_context('plugins');

$sidebar = elgg_view('plugins/search/sidebar');

// hack the title
$body = $vars['body'];
$title_section = trim(sprintf(elgg_echo('search:results'), ''));
$body = str_replace("<h2>$title_section", "<h2>Plugins matching", $body);

echo elgg_view_layout('plugins_layout', $body, $sidebar);
