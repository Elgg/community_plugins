<?php
/**
 * Overrides for the groups plugin on Elgg community site
 *
 */

elgg_register_event_handler('init', 'system', 'community_groups_init');

/**
 * Initialize the community groups extension plugin
 */
function community_groups_init() {

	$action_path = elgg_get_plugins_path() . 'community_groups/actions';

	elgg_extend_view('css/elgg', 'community_groups/css');

	// admin controls use a lightbox
	if (elgg_in_context('discussion') && elgg_is_admin_logged_in()) {
		elgg_load_js('lightbox');
		elgg_load_css('lightbox');
	}

	// group tabs
	if (elgg_in_context('groups')) {
		elgg_register_plugin_hook_handler('register', 'menu:filter', 'community_groups_filter_menu');
	}
	elgg_register_plugin_hook_handler('route', 'groups', 'community_groups_router');

	// do not need normal sidebar menu in community site
	elgg_unregister_event_handler('pagesetup', 'system', 'groups_setup_sidebar_menus');

	// only admins can create groups
	elgg_register_plugin_hook_handler('register', 'menu:title', 'community_groups_restrict_group_add_button');
	elgg_register_plugin_hook_handler('action', 'groups/edit', 'community_groups_restrict_group_add_action');

	// groups administration
	elgg_register_menu_item('page', array(
		'name' => 'groups',
		'href' => 'admin/groups/main',
		'text' => elgg_echo('admin:groups'),
		'context' => 'admin',
		'priority' => 200,
		'section' => 'administer'
	));
	elgg_register_action('groups/combine', "$action_path/groups/combine.php", 'admin');
	elgg_register_action('groups/categorize', "$action_path/groups/categorize.php", 'admin');
	elgg_register_action("groups/delete", elgg_get_plugins_path() . "groups/actions/groups/delete.php", 'admin');
	elgg_register_action("groups/saveblogsettings", "$action_path/groups/saveblogsettings.php", 'admin');
	elgg_register_action("groups/change_owner", "$action_path/groups/change_owner.php", 'admin');


	// set up site menu for discussion
	$item = new ElggMenuItem('discussion', elgg_echo('discussion'), 'discussion/all');
	elgg_register_menu_item('site', $item);

	// modify the menus on discussion posts
	if (elgg_is_admin_logged_in()) {
		elgg_register_plugin_hook_handler('register', 'menu:cg:moderator', 'community_groups_moderator_menu');
		elgg_extend_view('object/groupforumtopic', 'community_groups/discussion/controls');
		elgg_extend_view('annotation/group_topic_post', 'community_groups/discussion/controls');
		elgg_register_ajax_view('community_groups/discussion/offtopic');
		elgg_register_ajax_view('community_groups/discussion/move');
	}
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'community_groups_limit_editing');
	elgg_register_plugin_hook_handler('register', 'menu:annotation', 'community_groups_limit_editing');

	elgg_register_action('discussion/move', "$action_path/discussion/move.php", 'admin');
	elgg_register_action('discussion/remove_ad', "$action_path/discussion/remove_ad.php", 'admin');
	elgg_register_action('discussion/offtopic', "$action_path/discussion/offtopic.php", 'admin');

/*

	register_plugin_hook('search_types', 'get_types', 'community_groups_add_search_type');

	// need to work on sorting by relevance rather than date
	//register_plugin_hook('search', 'discussion', 'search_discussion_hook');


*/
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
		false,
		false
	);
}

/**
 * Replace the filter menu for group selection
 *
 * @param string $hook   Hook name
 * @param string $type   Hook type
 * @param array  $menu   Menu items
 * @param array  $params Parameters for the menu
 * @return array
 */
function community_groups_filter_menu($hook, $type, $menu, $params) {

	// main page does not have the filter request param
	$main_page = !(bool)get_input('filter');

	$menu = array();
	$groups = array('featured', 'popular', 'support', 'language', 'developers', 'plugins');
	$priority = 100;
	foreach ($groups as $name) {
		$options = array(
			'name' => $name,
			'text' => elgg_echo("groups:$name"),
			'href' => "groups/all?filter=$name",
			'priority' => $priority++,
		);
		if ($main_page && $name == 'featured') {
			$options['selected'] = true;
		}
		$menu[] = ElggMenuItem::factory($options);
	}

	return $menu;
}

/**
 * Route overridden group pages
 *
 * @param type $hook    The name of the hook
 * @param type $context The context/handler
 * @param type $params  The parameters for routing
 */
function community_groups_router($hook, $context, $params) {
	if ($params['segments'][0] == 'all') {
		$community_base = elgg_get_plugins_path() . "community_groups/pages";
		require "$community_base/groups.php";
		return false;
	}
}

/**
 * Remove the group add button for non-admins
 *
 * @param string $hook Hook name
 * @param string $type Hook type
 * @param array  $menu Array of ElggMenuItem objects
 * @return array
 */
function community_groups_restrict_group_add_button($hook, $type, $menu) {
	if (elgg_get_context() == 'groups') {
		if (!elgg_is_admin_logged_in()) {
			foreach ($menu as $index => $item) {
				if ($item->getName() == 'add') {
					unset($menu[$index]);
				}
			}
		}
	}
	return $menu;
}

/**
 * Only allow admins to create groups.
 * Catches the edit action and if this is a new group, checks that
 * an admin is logged in. If an existing group, lets the action proceed.
 */
function community_groups_restrict_group_add_action() {
	$guid = get_input('group_guid', 0);
	if ($guid) {
		// group edit action
		return true;
	}

	// group create
	return elgg_is_admin_logged_in();
}

/**
 * Add moderator buttons for discussions
 *
 * @param string $hook
 * @param string $type
 * @param array  $menu
 * @param array  $params
 */
function community_groups_moderator_menu($hook, $type, $menu, $params) {
	if (isset($params['entity'])) {
		$entity = $params['entity'];
		$options = array(
			'name' => 'move',
			'text' => elgg_echo('cg:menu:move'),
			'href' => "ajax/view/community_groups/discussion/move?guid=" . $entity->getGUID(),
			'link_class' => 'elgg-lightbox',
		);
		$menu[] = ElggMenuItem::factory($options);
		$options = array(
			'name' => 'remove_ad',
			'text' => elgg_echo('cg:menu:remove_ad'),
			'href' => "action/discussion/remove_ad?guid=" . $entity->getGUID(),
			'is_action' => true,
		);
		$menu[] = ElggMenuItem::factory($options);
		return $menu;
	} else if (isset($params['annotation'])) {
		$reply = $params['annotation'];
		$options = array(
			'name' => 'offtopic',
			'text' => elgg_echo('cg:menu:offtopic'),
			'href' => "ajax/view/community_groups/discussion/offtopic?id=" . $reply->id,
			'link_class' => 'elgg-lightbox',
		);
		$menu[] = ElggMenuItem::factory($options);
		$options = array(
			'name' => 'remove_ad',
			'text' => elgg_echo('cg:menu:remove_ad'),
			'href' => "action/discussion/remove_ad?id=" . $reply->id,
			'is_action' => true,
		);
		$menu[] = ElggMenuItem::factory($options);
		return $menu;
	}
}

/**
 * Limit editing of discussion topics based on time since posted
 *
 * This is to prevent people from posting inflammatory comments and then
 * editing them before an admin sees them.
 *
 * @param string $hook
 * @param string $type
 * @param array  $menu
 * @param array  $params
 */
function community_groups_limit_editing($hook, $type, $menu, $params) {
	if (!elgg_in_context('discussion')) {
		return;
	}

	if ($type == 'menu:entity') {
		$object = $params['entity'];
		if (!elgg_instanceof($object, 'object', 'groupforumtopic')) {
			return;
		}
	} else {
		$object = $params['annotation'];
		if ($object->getSubtype() != 'group_topic_post') {
			return;
		}
	}

	$owner_guid = $object->getOwnerGUID();
	$time = $object->getTimeCreated();

	if (!community_groups_can_edit($owner_guid, $time)) {
		foreach ($menu as $index => $item) {
			if ($item->getName() == 'edit') {
				unset($menu[$index]);
			}
		}
	}
	if (!community_groups_can_delete($owner_guid, $time)) {
		foreach ($menu as $index => $item) {
			if ($item->getName() == 'delete') {
				unset($menu[$index]);
			}
		}
	}
	
	return $menu;
}

/**
 * Can this viewer edit this forum topic/comment
 *
 * @param int $owner_guid
 * @param int $time_created
 * @return bool
 */
function community_groups_can_edit($owner_guid, $time_created) {
	if (elgg_is_admin_logged_in()) {
		return true;
	}

	// they have 30 minutes to edit
	if (elgg_get_logged_in_user_guid() == $owner_guid) {
		if ((time() - $time_created) < 30 * 60) {
			return true;
		}
	}

	return false;
}

/**
 * Can this viewer delete this forum topic/comment
 *
 * @param int $owner_guid
 * @param int $time_created
 * @return bool
 */
function community_groups_can_delete($owner_guid, $time_created) {
	if (elgg_is_admin_logged_in()) {
		return true;
	}

	// they have 5 minutes to delete
	if (elgg_get_logged_in_user_guid() == $owner_guid) {
		if ((time() - $time_created) < 5 * 60) {
			return true;
		}
	}

	return false;
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
	$limit = sanitise_int($params['limit']);
	$offset = sanitise_int($params['offset']);

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
		$container_and = 'AND e.container_guid = ' . sanitise_int($params['container_guid']);
	}

	$e_access = get_access_sql_suffix('e');
	$a_access = get_access_sql_suffix('a');

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

	// don't continue if nothing there...
	if (!$count) {
		return array ('entities' => array(), 'count' => 0);
	}


	$score = trim($search_where, '()') . ')';

	// @todo this can probably be done through the api..
	$q = "SELECT DISTINCT a.*, msv.string as comment FROM {$CONFIG->dbprefix}annotations a,
		$score as score
		JOIN {$CONFIG->dbprefix}metastrings msn ON a.name_id = msn.id
		JOIN {$CONFIG->dbprefix}metastrings msv ON a.value_id = msv.id
		JOIN {$CONFIG->dbprefix}entities e ON a.entity_guid = e.guid
		WHERE msn.string = 'group_topic_post'
			AND $search_where
			AND $e_access
			AND $a_access
			$container_and

		LIMIT $offset, $limit
		";

	$comments = get_data($q);

	var_dump($comments);
	
	var_dump($q);
	exit;

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

/**
 * Post a blog post in the blog forum
 *
 * @param string $username
 * @param string $title
 * @param string $body
 * @param string $token
 * @return bool
 */
function community_groups_post_blog($username, $title, $body, $token) {

	$stored_token = elgg_get_plugin_setting('blog_token', 'community_groups');
	if ($stored_token !== $token) {
		throw new InvalidParameterException('Bad token');
	}

	$title = "Elgg Blog: $title";

	// blog.elgg.org to community.elgg.org
	$username_mapping = array(
		'brett' => 'brett.profitt',
		'cash' => 'costelloc',
		'evan' => 'ewinslow',
		'nick' => 'nickw',

		// gsoc11
		'saket' => 'tachyon',
		'francisco' => 'paco',
		'ravindra' => 'blacktooth',
	);

	if (!array_key_exists($username, $username_mapping)) {
		throw new InvalidParameterException('Unknown user');
	}

	$username = $username_mapping[$username];
	$user = get_user_by_username($username);
	if (!$user) {
		throw new InvalidParameterException('Unable to get user');
	}
	login($user);

	$group_guid = elgg_get_plugin_setting('blog_group_guid', 'community_groups');
	if (!$group_guid) {
		throw new InvalidParameterException('Group GUID is not set');
	}

	$grouptopic = new ElggObject();
	$grouptopic->subtype = "groupforumtopic";
	$grouptopic->owner_guid = $user->getGUID();
	$grouptopic->container_guid = $group_guid;
	$grouptopic->access_id = ACCESS_PUBLIC;
	$grouptopic->title = $title;
	$grouptopic->description = $body;
	$grouptopic->status = 'open';

	if (!$grouptopic->save()) {
		throw new InvalidParameterException('Unable to save post');
	}

	add_to_river('river/object/groupforumtopic/create', 'create', $user->getGUID(), $grouptopic->guid);

	return true;
}
