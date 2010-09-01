<?php
/**
 * Overrides for the groups plugin on Elgg community site
 *
 */

register_elgg_event_handler('init', 'system', 'community_groups_init');

function community_groups_init() {
	global $CONFIG;

	elgg_extend_view('css', 'community_groups/css');

	register_elgg_event_handler('pagesetup', 'system', 'community_groups_adminmenu');
	register_page_handler('groupsadmin', 'community_groups_admin_page');

	register_page_handler('groups', 'community_groups_page_handler');
	register_elgg_event_handler('pagesetup', 'system', 'community_groups_sidebar_menu');

	register_plugin_hook('search_types', 'get_types', 'community_groups_add_search_type');
	register_plugin_hook('search', 'discussion', 'search_discussion_hook');

	$action_path = $CONFIG->pluginspath . 'community_groups/actions';
	register_action('forum/move', FALSE, "$action_path/forum/move.php", TRUE);
	register_action('forum/remove_ad', FALSE, "$action_path/forum/remove_ad.php", TRUE);
	register_action('groups/combine', FALSE, "$action_path/groups/combine.php", TRUE);
	register_action('groups/categorize', FALSE, "$action_path/groups/categorize.php", TRUE);
	register_action("groups/delete", FALSE, $CONFIG->pluginspath . "groups/actions/delete.php", TRUE);
	register_action("groups/saveblogsettings", FALSE, "$action_path/groups/saveblogsettings.php", TRUE);

	expose_function(
		'blog.post',
		'community_groups_post_blog',
		array(
			'username' => array('type' => 'string'),
			'title' => array('type' => 'string'),
			'body' => array('type' => 'string'),
			'token' => array('type' => 'string'),
		),
		'Post a blog.elgg.org blog post to the group forums',
		'POST',
		FALSE,
		FALSE
	);
}

/**
 * Add a menu item for groups admin pages
 */
function community_groups_adminmenu() {
	global $CONFIG;
	if (get_context() == 'admin') {
		add_submenu_item(elgg_echo('cp:groups:admin'), "{$CONFIG->url}pg/groupsadmin/");
	}
}

/**
 * Group admin pages
 *
 * @param array $page
 */
function community_groups_admin_page($page) {

	set_context('admin');

	$tab = 'combine';
	if (isset($page[0])) {
		$tab = $page[0];
	}

	$title = elgg_echo('cp:groups:admin');

	$content = elgg_view_title($title);
	$content .= elgg_view('community_groups/admin/main', array('tab' => $tab));

	$body = elgg_view_layout('two_column_left_sidebar', '', $content);

	page_draw($title, $body);
	return TRUE;
}

/**
 * Replaces page handler of groups plugin
 *
 * @param array $page
 */
function community_groups_page_handler($page) {
	global $CONFIG;

	$groups_base = "{$CONFIG->pluginspath}groups";
	$community_base = "{$CONFIG->pluginspath}community_groups/pages";

	if (!isset($page[0])) {
		// default to group listing page
		$page[0] = 'world';
	}

	switch ($page[0]) {
		case "invitations":
			include("$groups_base/invitations.php");
			break;
		case "new":
			include("$groups_base/new.php");
			break;
		case "world":
			include("$community_base/groups.php");
			break;
		case "forum":
			set_input('group_guid', $page[1]);
			include("$groups_base/forum.php");
			break;
		case "owned":
			// groups owned by user
			set_input('username', $page[1]);
			include("$groups_base/index.php");
			break;
		case "member":
			// groups user is a member of
			set_input('username', $page[1]);
			include("$groups_base/membership.php");
			break;
		case "memberlist":
			set_input('group_guid', $page[1]);
			include($CONFIG->pluginspath . "groups/memberlist.php");
			break;
		case "discussion":
			set_input('filter', $page[1]);
			include("$community_base/discussion.php");
			break;
		default:
			// group profile
			set_input('group_guid', $page[0]);
			include("$groups_base/groupprofile.php");
			break;
	}

	return TRUE;
}

/**
 * Add sidebar memu items for groups
 */
function community_groups_sidebar_menu() {
	global $CONFIG;

	if (get_context() != 'groups') {
		return;
	}

	// remove create group link for non-admins
	if (!isadminloggedin()) {
		community_groups_remove_submenu_item(elgg_echo('groups:new'));
	}

	$group = page_owner_entity();
	if (!($group instanceof ElggGroup)) {
		return;
	}

	if ($group->isMember(get_loggedin_user())) {
		add_submenu_item(elgg_echo('groups:addtopic'), $CONFIG->wwwroot . "mod/groups/addtopic.php?group_guid={$group->getGUID()}", '1groupslinks');
	}


}

/**
 * Can this viewer edit this forum topic/comment
 *
 * @param int $owner_guid
 * @param int $time_created
 * @return bool
 */
function community_groups_can_edit($owner_guid, $time_created) {
	if (isadminloggedin()) {
		return TRUE;
	}

	if (get_loggedin_userid() == $owner_guid) {
		if ((time() - $time_created) < 30 * 60) {
			return TRUE;
		}
	}

	return FALSE;
}

/**
 * Get a list of group categories
 *
 * @return array
 */
function community_groups_get_categories() {
	return array('support', 'plugins', 'language', 'developers');
}


function community_groups_add_search_type($hook, $type, $value, $params) {
	$value[] = 'discussion';
	return $value;
}

/**
 * Return search results on discussion comments.
 *
 * @param string $hook
 * @param string $type
 * @param mixed $value
 * @param array $params
 * @return array
 */
function search_discussion_hook($hook, $type, $value, $params) {
	global $CONFIG;

	$query = sanitise_string($params['query']);
	$params['annotation_names'] = array('group_topic_post');

	$params['joins'] = array(
		"JOIN {$CONFIG->dbprefix}annotations a on e.guid = a.entity_guid",
		"JOIN {$CONFIG->dbprefix}metastrings msn on a.name_id = msn.id",
		"JOIN {$CONFIG->dbprefix}metastrings msv on a.value_id = msv.id"
	);

	$fields = array('string');

	// force IN BOOLEAN MODE since fulltext isn't
	// available on metastrings (and boolean mode doesn't need it)
	$search_where = search_get_where_sql('msv', $fields, $params, FALSE);

	$container_and = '';
	if ($params['container_guid'] && $params['container_guid'] !== ELGG_ENTITIES_ANY_VALUE) {
		$container_and = 'AND e.container_guid = ' . sanitise_string($params['container_guid']);
	}

	$e_access = get_access_sql_suffix('e');
	$a_access = get_access_sql_suffix('a');
	// @todo this can probably be done through the api..
	$q = "SELECT DISTINCT a.*, msv.string as comment FROM {$CONFIG->dbprefix}annotations a
		JOIN {$CONFIG->dbprefix}metastrings msn ON a.name_id = msn.id
		JOIN {$CONFIG->dbprefix}metastrings msv ON a.value_id = msv.id
		JOIN {$CONFIG->dbprefix}entities e ON a.entity_guid = e.guid
		WHERE msn.string = 'group_topic_post'
			AND ($search_where)
			AND $e_access
			AND $a_access
			$container_and

		LIMIT {$params['offset']}, {$params['limit']}
		";

	$comments = get_data($q);

	$q = "SELECT count(DISTINCT a.id) as total FROM {$CONFIG->dbprefix}annotations a
		JOIN {$CONFIG->dbprefix}metastrings msn ON a.name_id = msn.id
		JOIN {$CONFIG->dbprefix}metastrings msv ON a.value_id = msv.id
		JOIN {$CONFIG->dbprefix}entities e ON a.entity_guid = e.guid
		WHERE msn.string = 'group_topic_post'
			AND ($search_where)
			AND $e_access
			AND $a_access
			$container_and
		";

	$result = get_data($q);
	$count = $result[0]->total;

	if (!is_array($comments)) {
		return FALSE;
	}

	// @todo if plugins are disabled causing subtypes
	// to be invalid and there are comments on entities of those subtypes,
	// the counts will be wrong here and results might not show up correctly,
	// especially on the search landing page, which only pulls out two results.

	// probably better to check against valid subtypes than to do what I'm doing.

	// need to return actual entities
	// add the volatile data for why these entities have been returned.
	$entities = array();
	foreach ($comments as $comment) {
		$entity = get_entity($comment->entity_guid);

		// hic sunt dracones
		if (!$entity) {
			//continue;
			$entity = new ElggObject();
			$entity->setVolatileData('search_unavailable_entity', TRUE);
		}

		$comment_str = search_get_highlighted_relevant_substrings($comment->comment, $query);
		$entity->setVolatileData('search_match_annotation_id', $comment->id);
		$entity->setVolatileData('search_matched_comment', $comment_str);
		$entity->setVolatileData('search_matched_comment_owner_guid', $comment->owner_guid);
		$entity->setVolatileData('search_matched_comment_time_created', $comment->time_created);
		$entities[] = $entity;
	}

	return array(
		'entities' => $entities,
		'count' => $count,
	);
}

function community_groups_remove_submenu_item($label) {
	global $CONFIG;

	if (!isset($CONFIG->submenu)) {
		return;
	}

	foreach ($CONFIG->submenu as $group_index => $group) {
		foreach ($group as $item_index => $item) {
			if ($item->name == $label) {
				unset($CONFIG->submenu[$group_index][$item_index]);
				return;
			}
		}
	}
}

function community_groups_post_blog($username, $title, $body, $token) {
	$stored_token = get_plugin_setting('blog_token', 'community_groups');
	if ($stored_token !== $token) {
		throw new InvalidParameterException('Bad token');
	}

	$title = "Elgg Blog: $title";

	// blog.elgg.org to community.elgg.org
	$username_mapping = array(
		'brett' => 'brett.profitt',
		'cash' => 'costelloc',
		'evan' => 'evan',
		'nick' => 'nickw',
	);

	if (!array_key_exists($username, $username_mapping)) {
		throw new InvalidParameterException('Unknown user');
	}

	$username = $username_mapping[$username];
	$user = get_user_by_username($username);
	if (!$user) {
		throw new InvalidParameterException('Unable to get user');
	}

	$group_guid = get_plugin_setting('blog_group_guid', 'community_groups');
	if (!$group_guid) {
		throw new InvalidParameterException('Group GUID is not set');
	}

	$grouptopic = new ElggObject();
	$grouptopic->subtype = "groupforumtopic";
	$grouptopic->owner_guid = $user->getGUID();
	$grouptopic->container_guid = $group_guid;
	$grouptopic->access_id = ACCESS_PUBLIC;
	$grouptopic->title = $title;
	$grouptopic->status = 'open';

	if (!$grouptopic->save()) {
		throw new InvalidParameterException('Unable to save post');
	}

	// now add the topic message as an annotation
	$grouptopic->annotate('group_topic_post', $body, ACCESS_PUBLIC, $user->getGUID());

	add_to_river('river/forum/topic/create', 'create', $user->getGUID(), $grouptopic->guid);

	return TRUE;
}
