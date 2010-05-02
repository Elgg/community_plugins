<?php
/**
 * Unused?
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

var_dump($CONFIG->site->plugins_download_count);

//download stats
$area1 .= "<p><span>" . get_entities("object", "plugin_project", 0, "", 0, 0, true) . "</span> plugins with <span>" . (int)$CONFIG->site->plugins_download_count . "</span> total downloads.</p>";
//list newest
$area2 = get_entities('object',"plugin_project");
//Most downloaded
set_context('search');
$area3 = get_entities_from_annotation_count("object", "plugin_project", "download");
//Most dugg
$area4 = get_entities_from_annotation_count("object", "plugin_project", "plugin_digg");
set_context('plugin_project');

$body = elgg_view_layout('plugin_frontpage',$area1,$area2,$area3,$area4);

// Finally draw the page
page_draw(sprintf(elgg_echo("plugins:yours"),$_SESSION['user']->name), $body);
