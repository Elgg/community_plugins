<?php
/**
 * Listing page of all groups
 */

$limit = get_input("limit", 10);
$offset = get_input("offset", 0);
$tag = get_input("tag");
$filter = get_input("filter");
if (!$filter) {
	// active discussions is the default
	$filter = "active";
}


$context = get_context();
set_context('search');
if ($tag != "") {
	$filter = 'search';
	// groups plugin saves tags as "interests" - see groups_fields_setup() in start.php
	$objects = list_entities_from_metadata('interests',$tag,'group',"","", $limit, false, false, true, false);
} else {
	switch($filter) {
		case "pop":
			$objects = list_entities_by_relationship_count('member', true, "", "", 0, $limit, false);
			break;
		case "featured":
			$objects = list_entities_from_metadata('featured_group','yes','group',"","", $limit, false, false, true, false);
			break;
		case "language":
			$objects = list_entities_from_metadata('group_category','language','group',"","", $limit, false, false, true, false);
			break;
		case "plugins":
			$objects = list_entities_from_metadata('group_category','plugins','group',"","", $limit, false, false, true, false);
			break;
		case "developers":
			$objects = list_entities_from_metadata('group_category','developers','group',"","", $limit, false, false, true, false);
			break;
		case "support":
			$objects = list_entities_from_metadata('group_category','support','group',"","", $limit, false, false, true, false);
			break;
		case "active":
		case 'default':
			$objects = list_entities_from_annotations("object", "groupforumtopic", "group_topic_post", "", 40, 0, 0, false, true);
			break;
	}
}

//get a group count
$options = array('type' => 'group', 'limit' => 0, 'count' => TRUE);
$group_count = elgg_get_entities($options);

//find groups
$area1 = elgg_view("groups/find");

//menu options
$area1 .= elgg_view("groups/side_menu");

//featured groups
$featured_groups = elgg_get_entities_from_metadata(array('metadata_name' => 'featured_group', 'metadata_value' => 'yes', 'types' => 'group', 'limit' => 10));
$area1 .= elgg_view("groups/featured", array("featured" => $featured_groups));


set_context($context);

$title = elgg_echo("groups:all");
$area2 = elgg_view_title($title);
$area2 .= elgg_view('groups/contentwrapper', array('body' => elgg_view("groups/group_sort_menu", array("count" => $group_count, "filter" => $filter)) . $objects));
$body = elgg_view_layout('sidebar_boxes', $area1, $area2);

page_draw($title, $body);
