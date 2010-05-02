<?php
/**
 * Unused page?
 */
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$limit = get_input("limit", 20);
$offset = get_input("offset", 0);
$tag = get_input("tag");

//get some criteria
$plugin_type = get_input("plugin_type", 'plugin');
$sort = get_input("sort", 'newest');
$search = get_input("search", false);

//select the correct title
if($plugin_type == 'langaugepack'){
	$area2 .= elgg_view_title($title = elgg_echo('plugins:languagepack'));
}elseif($plugin_type == 'theme'){
	$area2 .= elgg_view_title($title = elgg_echo('plugins:theme'));
}else{
	$area2 .= elgg_view_title($title = elgg_echo('plugins:plugin'));
}

set_context('search');
//if it is a search display the results, otherwise grab plugins order by newest
if($search == 'true'){
	$area2 .= "<div style=\"margin:10px 0 10px 0;\">" . elgg_view("plugins/search_plugins") . "</div>";
	//get search results
	$get_search = list_entities_from_metadata('',$tag,'object','plugin_project', 0, 20,false,false,true);
	if($get_search){
		$area2 .= "<div class=\"clearfloat\"></div><div style=\"margin:10px 0 10px 0;\">" . $get_search . "</div>";
	}else{
		$area2 .= "<div class=\"clearfloat\"></div><p>There are no plugins that match your search.</p>";
	}
}else{
	$area2 .= elgg_view("plugins/search_plugins");
	//used to sort the results by newest or popular
	if($sort == 'newest'){
		$area2 .= list_entities_from_metadata('plugin_type',$plugin_type,'object','plugin_project', 0,20,false,false,true);
	} elseif($sort == '1.5'){
		$meta = array('plugin_type' => $plugin_type, 'elgg_version' => '1.5');
		$area2 .= list_entities_from_metadata_multi($meta,'object','plugin_project', 0, 20,false,false,true);
	}elseif($sort == '1.6'){
		$meta = array('plugin_type' => $plugin_type, 'elgg_version' => '1.6');
		$area2 .= list_entities_from_metadata_multi($meta,'object','plugin_project', 0, 20,false,false,true);
	}else{
		$area2 .= list_entities_from_annotation_count_by_metadata("object", "plugin_project", "download", 'plugin_type', $plugin_type, 20, 0, 0, false, false, false, true, 'desc');
	}
}

//download stats
$area3 .= "<div class='plugin_stats'>" . elgg_view_title(elgg_echo('plugins:stats'));
$area3 .= "<p><span>" . get_entities("object", "plugin_project", 0, "", 0, 0, true) . "</span> plugins with <span>" . (int)$CONFIG->site->plugins_download_count . "</span> total downloads.</p></div>";
//featured plugins
$area3 .= elgg_view("plugins/featured_plugins");
set_context('plugins');
$body = elgg_view_layout('plugin_browse',$area1, $area2, $area3);

// Finally draw the page
page_draw(sprintf(elgg_echo("plugins:yours"),$_SESSION['user']->name), $body);