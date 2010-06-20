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

	$action_path = $CONFIG->pluginspath . 'community_groups/actions';
	register_action('forum/move', FALSE, "$action_path/forum/move.php", TRUE);
	register_action('forum/remove_ad', FALSE, "$action_path/forum/remove_ad.php", TRUE);
	register_action('groups/combine', FALSE, "$action_path/groups/combine.php", TRUE);
	register_action('groups/categorize', FALSE, "$action_path/groups/categorize.php", TRUE);
	register_action("groups/delete", FALSE, $CONFIG->pluginspath . "groups/actions/delete.php", TRUE);
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
			include("$community_base/all.php");
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
