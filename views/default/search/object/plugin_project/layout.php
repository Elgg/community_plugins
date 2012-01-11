<?php
/**
 * Elgg plugin search - override the layout for plugins
 */

set_context('plugins');

$sidebar = elgg_view('plugins/search/sidebar');


// hack the title
$body = $vars['body'];
$title_section = trim(sprintf(elgg_echo('search:results'), ''));
$body = str_replace("<h2>$title_section", "<h2>Plugins matching", $body);

// hack the section heading
$category = get_input('category', 'all');
$searchbar = elgg_view('plugins/search_box', array('category' => $category));
$type_string = elgg_echo("item:{$vars['params']['type']}:{$vars['params']['subtype']}");
$heading = elgg_view_title($type_string);
$body = str_replace($heading, $searchbar, $body, $count);
if ($count == 0) {
	// no results so we need to insert search bar
	$results = '</h2></div>';
	$new_results = "</h2></div>$searchbar";
	$body = str_replace($results, $new_results, $body);
}

echo elgg_view_layout('plugins_layout', $body, $sidebar);
