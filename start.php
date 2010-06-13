<?php
/**
 * Overrides for the groups plugin on Elgg community site
 * 
 */

register_elgg_event_handler('init', 'system', 'community_groups_init');

function community_groups_init() {
	global $CONFIG;

	elgg_extend_view('css', 'community_groups/css');

	$action_path = $CONFIG->pluginspath . 'community_groups/actions';
	register_action('forum/move', FALSE, "$action_path/forum/move.php", TRUE);
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

