<?php
/**
 * List discussion
 */

global $CONFIG;

$limit = get_input("limit", 10);
$offset = get_input("offset", 0);
$filter = get_input("filter", "latest");


$context = get_context();
set_context('search');
switch($filter) {
	case "mine":
		$listing = list_entities_from_annotations("object", "groupforumtopic", "group_topic_post", "", 20, get_loggedin_userid(), 0, false, true);
		break;
	case "mygroups":
		// get array of group ids this user belongs to
		$guid = get_loggedin_userid();
		$where = "guid_one='$guid' AND relationship='member'";
		$query = "SELECT * from {$CONFIG->dbprefix}entity_relationships where {$where}";
		$rel = get_data($query, "row_to_elggrelationship");
		$group_guids = array();
		foreach ($rel as $membership) {
			$group_guids[] = $membership->guid_two;
		}

		// get latest discussion posts in these groups
		$options = array('type' => 'object',
						'subtype' => 'groupforumtopic',
						'annotation_names' => 'group_topic_post',
						'container_guids' => $group_guids,
						'limit' => 0,
						'count' => TRUE);
		$num_topics = elgg_get_entities_from_annotations($options);
		$options['count'] = FALSE;
		$topics = elgg_get_entities_from_annotations($options);
		$listing = elgg_view_entity_list($topics, $num_topics, 0, 20, FALSE, FALSE);
		break;
	case "latest":
	default:
		$listing = list_entities_from_annotations("object", "groupforumtopic", "group_topic_post", "", 20, 0, 0, false, true);
		break;
}

set_context($context);

$title = elgg_echo("groups:discussion");
$area2 = elgg_view_title($title);

$content = elgg_view("community_groups/discussion_sort_menu", array("filter" => $filter));
$content .= $listing;

$area2 .= elgg_view('groups/contentwrapper', array('body' => $content));

$area1 = elgg_view('community_groups/discussion_sidebar');

$body = elgg_view_layout('sidebar_boxes', $area1, $area2);

page_draw($title, $body);
