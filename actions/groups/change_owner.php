<?php

$group_guid = get_input('group_guid', 0);
if ($user_guid_array = get_input('user_guid_array', FALSE)) {
	$user_guid = array_key_exists(0, $user_guid_array) ? $user_guid_array[0] : FALSE;
}

$group = get_entity($group_guid);
$user = get_entity($user_guid);

if (!$group) {
	register_error(elgg_echo('cg:admin:change_owner:nogroup'));
	forward(REFERER);
}

if (!$user) {
	register_error(elgg_echo('cg:admin:change_owner:nouser'));
	forward(REFERER);
}

// change owner guid on group entity
$old_owner = $group->owner_guid;
$group->owner_guid = $user->guid;
$group->container_guid = $user->guid;

if (!$group->save()) {
	register_error(elgg_echo('cg:admin:change_owner:failure'));
	forward(REFERER);
}

// make sure the new owner is also a member.
if (!$group->isMember($user)) {
	$group->join($user);
}


// move the icons to the new owner
$icon_error = FALSE;

// there's an icon without a size--just the group guid.
$sizes = array('', 'large', 'medium', 'small', 'tiny', 'master', 'topbar');
$old_icon = new ElggFile();
$old_icon->owner_guid = $old_owner;

$new_icon = new ElggFile();
$new_icon->owner_guid = $user->guid;

foreach ($sizes as $size) {
	$filename = "groups/{$group->guid}$size.jpg";
	$old_icon->setFilename($filename);

	if ($old_icon->exists()) {
		$new_icon->setFilename($filename);
		$new_icon->open('write');
		$old_icon->open('read');
		if ($new_icon->write($old_icon->grabFile())) {
			$old_icon->delete();
		} else {
			$icon_error = TRUE;
		}
		$new_icon->close();
	}
}

if (!$icon_error) {
	system_message(sprintf(elgg_echo('cg:admin:change_owner:success'), $user->name, $group->name));
} else {
	register_error(elgg_echo('cg:admin:change_owner:icon_error'));
}

forward(REFERER);