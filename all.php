<?php
/**
 * Front page for plugin repository
 */

// leave direct call to engine because previous very skipped page handler
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

//Newest
$newest = elgg_get_entities(array('type' => 'object', 'subtype' => 'plugin_project'));

//Most downloaded
set_context('search');
$popular = __get_entities_from_annotations_calculate_x('count', 'object', 'plugin_project', 'download');

//Most dugg
$dugg = __get_entities_from_annotations_calculate_x('count', 'object', 'plugin_project', 'plugin_digg');

//Last updated
$updated = elgg_get_entities(array('object' => 'plugin_project', 'order_by' => 'e.time_updated desc'));
set_context('plugin_project');

$welcome = elgg_view('plugins/front/main');
$sidebar = elgg_view('plugins/categories');
$bottom = elgg_view('plugins/front/bottom', array(	'newest' => $newest,
													'updated' => $updated,
													'popular' => $popular,
													'dugg' => $dugg,));


$body = elgg_view_layout('plugins_layout', $welcome, $sidebar, $bottom);

page_draw(elgg_echo("plugins:all"), $body);
