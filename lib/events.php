<?php

namespace Elgg\CommunityPlugins;


/**
 * Sets up submenus. Triggered on pagesetup.
 *
 */
function add_submenus() {

	$plugins_base = elgg_get_site_url() . "plugins";

	if (elgg_get_context() == 'admin') {
		elgg_register_admin_menu_item('administer', 'statistics', 'community_plugins');
		elgg_register_admin_menu_item('administer', 'utilities', 'community_plugins');

		elgg_register_admin_menu_item('configure', 'community_plugins', 'settings');
		return;
	}

	if (elgg_get_context() != "plugins") {
		return;
	}

	$page_owner = elgg_get_page_owner_entity();

	if (elgg_is_logged_in() && elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
		elgg_register_menu_item('page', array(
			'href' => "$plugins_base/developer/$page_owner->username",
			'name' => 'plugins:yours',
			'text' => elgg_echo("plugins:yours", array(elgg_echo('plugins:types:'))),
		));
	} else if (elgg_get_page_owner_guid()) {
		$title = elgg_echo("plugins:user", array($page_owner->name, elgg_echo('plugins:types:')));
		elgg_register_menu_item('page', array(
			'href' => "$plugins_base/developer/$page_owner->username",
			'name' => 'plugins:user',
			'text' => $title,
		));
	}

	elgg_register_menu_item('page', array(
		'href' => '/plugins',
		'name' => 'plugins:all',
		'text' => elgg_echo('plugins:all'),
	));

	// add upload link when viewing own plugin page
	if (elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) {
		elgg_register_menu_item('page', array(
			'href' => "$plugins_base/new/project/$page_owner->username",
			'name' => 'plugins:upload',
			'text' => elgg_echo('plugins:upload'),
		));
	}
}

/**
 * Triggered on comment creation
 * Notifies plugin authors to comments on their releases
 * Needed because releases are owned by the plugins, not the authors
 * 
 * @param type $event
 * @param type $type
 * @param type $comment
 * @return boolean
 */
function release_comment_notification($event, $type, $comment) {
	
	if (!elgg_instanceof($comment, 'object', 'comment')) {
		return true;
	}
	
	$release = $comment->getContainerEntity();
	if (!elgg_instanceof($release, 'object', 'plugin_release')) {
		return true;
	}
	
	$entity = $release->getContainerEntity();
	
	// plugin releases are owned by the projects, so we need to notify
	// plugin owners manually
	// Notify if poster wasn't owner
	$user = $comment->getOwnerEntity();
	if ($entity->owner_guid != $user->guid) {
		$owner = $entity->getOwnerEntity();

		notify_user($owner->guid,
			$user->guid,
			elgg_echo('generic_comment:email:subject', array(), $owner->language),
			elgg_echo('generic_comment:email:body', array(
				$entity->title,
				$user->name,
				$comment->description,
				$release->getURL(),
				$user->name,
				$user->getURL()
			), $owner->language),
			array(
				'object' => $comment,
				'action' => 'create',
			)
		);
	}
	
	return true;
}


function project_update($event, $type, $project) {
	if (!elgg_instanceof($project, 'object', 'plugin_project')) {
		return true;
	}
	
	$project->updateReleaseTitles();
	return true;
}

function upgrades() {
	// only allow admin to perform upgrades
	if (!elgg_is_admin_logged_in()) {
		return true;
	}
	
	elgg_load_library('plugins:upgrades');
	run_function_once(__NAMESPACE__ . '\\upgrade_20141121');
	run_function_once(__NAMESPACE__ . '\\upgrade_20141125');
}