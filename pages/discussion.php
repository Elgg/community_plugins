<?php
/**
 * List discussion
 */

global $CONFIG;

$limit = get_input("limit", 10);
$offset = get_input("offset", 0);
$filter = get_input("filter", "latest");
if (!$filter) {
	$filter = 'latest';
}


$context = elgg_get_context();
elgg_set_context('search');
switch($filter) {
	case "mine":
		$options = array(
			'type' => 'object',
			'subtype' => 'groupforumtopic',
			'annotation_name' => 'group_topic_post',
			'limit' => 20,
			'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
		);
		$listing = elgg_list_entities_from_annotations($options);
		break;
//	case "mygroups":
//		// get array of group ids this user belongs to
//		$guid = get_loggedin_userid();
//		$where = "guid_one='$guid' AND relationship='member'";
//		$query = "SELECT * from {$CONFIG->dbprefix}entity_relationships where {$where}";
//		$rel = get_data($query, "row_to_elggrelationship");
//		$group_guids = array();
//		foreach ($rel as $membership) {
//			$group_guids[] = $membership->guid_two;
//		}
//
//		// get latest discussion posts in these groups
//		$options = array('type' => 'object',
//						'subtype' => 'groupforumtopic',
//						'annotation_names' => 'group_topic_post',
//						'container_guids' => $group_guids,
//						'limit' => 0,
//						'count' => TRUE);
//		$num_topics = elgg_get_entities_from_annotations($options);
//		$options['count'] = FALSE;
//		$topics = elgg_get_entities_from_annotations($options);
//		$listing = elgg_view_entity_list($topics, $num_topics, 0, 20, FALSE, FALSE);
//		break;
	case "latest":
	default:
		$options = array(
			'type' => 'object',
			'subtype' => 'groupforumtopic',
			'annotation_name' => 'group_topic_post',
			'limit' => 20,
		);
		$listing = elgg_list_entities_from_annotations($options);
		break;
}

elgg_set_context($context);

$title = elgg_echo("groups:discussion");
$area2 = elgg_view_title($title);

$content = elgg_view("community_groups/discussion_sort_menu", array("filter" => $filter));
$content .= $listing;

$area2 .= elgg_view('groups/contentwrapper', array('body' => $content));

$area1 = elgg_view('community_groups/discussion_sidebar');

$body = elgg_view_layout('sidebar_boxes', $area1, $area2);

$vars = array(
	'sidebar' => $sidebar
);
echo elgg_view_page($title, $body, 'default', $vars);
