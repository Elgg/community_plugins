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

	$action_path = $CONFIG->pluginspath . 'community_groups/actions';
	register_action('forum/move', FALSE, "$action_path/forum/move.php", TRUE);
	register_action('groups/combine', FALSE, "$action_path/groups/combine.php", TRUE);
	register_action('groups/categorize', FALSE, "$action_path/groups/categorize.php", TRUE);
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
	return array('featured', 'plugins', 'language', 'developers');
}
