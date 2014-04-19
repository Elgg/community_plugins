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
	elgg_register_plugin_hook_handler('route', 'discussion', 'community_groups_router');

	// do not need normal sidebar menu in community site
	elgg_unregister_event_handler('pagesetup', 'system', 'groups_setup_sidebar_menus');

	// only admins can create groups
	elgg_register_plugin_hook_handler('register', 'menu:title', 'community_groups_restrict_group_add_button');
	elgg_register_plugin_hook_handler('action', 'groups/edit', 'community_groups_restrict_group_edit_action');

    // attempt to join a group on first post		
	elgg_register_plugin_hook_handler('action', 'discussion/save', 'community_groups_discussion_save_handler');


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
		elgg_extend_view('object/discussion_reply', 'community_groups/discussion/controls');
		elgg_register_ajax_view('community_groups/discussion/offtopic');
	}
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'community_groups_limit_editing');

	elgg_register_action('discussion/remove_ad', "$action_path/discussion/remove_ad.php", 'admin');
	elgg_register_action('discussion/offtopic', "$action_path/discussion/offtopic.php", 'admin');

	if (function_exists("elgg_ws_expose_function")) {
		elgg_ws_expose_function(
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
}



/**
 * Attempt to join a group before posting a new discussion topic.
 *
 * @param string $hook   'action'
 * @param string $type   'discussion/save'
 * @param mixed  $result ignored
 * @param mixed  $params ignored
 * 
 * @return void
 */
function community_groups_discussion_save_handler($hook, $type, $result, $params) {
    // just editing existing topic, so we don't need to join for permission to do that
    if (get_input('topic_guid')) {
        return NULL;
    }
    
    $group = get_entity(get_input('container_guid'));
    
    // Not a valid group. The action will give the appropriate error message
    if (!$group) {
        return NULL;
    }
    
    // Already a member, so the permissions check is useless
    if ($group->isMember()) {
        return NULL;
    }
    
    // not a member; attempt join
    if ($group->isPublicMembership() && $group->join(elgg_get_logged_in_user_entity())) {
        system_message(elgg_echo("cg:groups:join:success", array($group->getDisplayName())));   
    } else {
        register_error(elgg_echo('cg:groups:join:failure', array($group->getDisplayName())));
    }
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
function community_groups_router($hook, $context, $params, $result) {
    if ($result === false) {
        return $result;
    }
    
    $community_base = __DIR__ . "/pages";
    
	if ($context == 'groups' && $params['segments'][0] == 'all') {
		require "$community_base/groups.php";
		return false;
	}
	
	if ($context == 'discussion') {
	    switch ($params['segments'][0]) {
	        case 'new':
        	    require "$community_base/discussion/new.php";
        	    return false;
        	case 'all':
        	    elgg_register_menu_item('title', array(
        	        'name' => 'discussion:add',
        	        'href' => '/discussion/new',
        	        'text' => elgg_echo('discussion:add'),
        	        'class' => 'elgg-button elgg-button-submit',
                ));
        	    break;
    	}
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
function community_groups_restrict_group_edit_action() {
	$guid = get_input('group_guid', 0);
	if ($guid) {
		// group edit action
		return true;
	}

	// group create
	return elgg_is_admin_logged_in();
}

/**
 * Add moderator buttons for discussions and discussion replies
 *
 * @param string $hook
 * @param string $type
 * @param array  $menu
 * @param array  $params
 */
function community_groups_moderator_menu($hook, $type, $menu, $params) {
	$entity = $params['entity'];

	if ($entity->getSubtype() === 'groupforumtopic') {
		$options = array(
			'name' => 'remove_ad',
			'text' => elgg_echo('cg:menu:remove_ad'),
			'href' => "action/discussion/remove_ad?guid=" . $entity->getGUID(),
			'is_action' => true,
		);
		$menu[] = ElggMenuItem::factory($options);
		return $menu;
	}

	if ($entity instanceof ElggDiscussionReply) {
		$options = array(
			'name' => 'offtopic',
			'text' => elgg_echo('cg:menu:offtopic'),
			'href' => "ajax/view/community_groups/discussion/offtopic?guid=" . $entity->guid,
			'link_class' => 'elgg-lightbox',
		);
		$menu[] = ElggMenuItem::factory($options);
		$options = array(
			'name' => 'remove_ad',
			'text' => elgg_echo('cg:menu:remove_ad'),
			'href' => "action/discussion/remove_ad?guid=" . $entity->guid,
			'is_action' => true,
		);
		$menu[] = ElggMenuItem::factory($options);
		return $menu;
	}
}

/**
 * Limit editing of discussion topics and replies based on time since posted
 *
 * This is to prevent people from posting inflammatory comments and then
 * editing them before an admin sees them.
 *
 * @param string         $hook
 * @param string         $type
 * @param ElggMenuItem[] $menu
 * @param array          $params
 */
function community_groups_limit_editing($hook, $type, $menu, $params) {
	if (!elgg_in_context('discussion')) {
		return;
	}

	$entity = $params['entity'];

	// Check that we're dealing either with a discussion or a discussion reply
	if ($entity->getSubtype() != 'groupforumtopic' && !$entity instanceof ElggDiscussionReply) {
		return;
	}

	$owner_guid = $entity->getOwnerGUID();
	$time = $entity->getTimeCreated();

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
		'steve' => 'steve_clay'
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

	elgg_create_river_item(array(
		'view' => 'river/object/groupforumtopic/create',
		'action_type' => 'create',
		'subject_guid' => $user->getGUID(),
		'object_guid' => $grouptopic->guid,
	));

	return true;
}
