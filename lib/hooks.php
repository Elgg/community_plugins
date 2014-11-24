<?php

namespace Elgg\CommunityPlugins;
use PluginProject;
use PluginRelease;
use ElggUser;
use ElggMenuItem;

/**
 * Prepare a notification message about a new plugin project or a new plugin release
 *
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg_Notifications_Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg_Notifications_Notification
 */
function prepare_notification($hook, $type, $notification, $params) {
	$entity = $params['event']->getObject();
	$owner = $params['event']->getActor();
	$recipient = $params['recipient'];
	$language = $params['language'];
	$method = $params['method'];

	$subtype = $entity->getSubtype();
	if ($subtype == 'plugin_project') {
		$text = $entity->description;
	} else {
		$text = $entity->release_notes;
	}

	// Notification title
	$notification->subject = elgg_echo("plugins:{$subtype}:notify:subject", array($owner->name, $entity->title), $language);

	// Notification body
	$notification->body = elgg_echo("plugins:{$subtype}:notify:body", array(
	    $owner->name,
	    $entity->title,
	    $text,
	    $entity->getURL()
	), $language);

	// Notification summary
	$notification->summary = elgg_echo("plugins:{$subtype}:notify:summary", array($entity->title), $language);

	return $notification;
}


/**
 * Get notification subscriptions for a new plugin release
 *
 * The Elgg 1.9 subscriptions system is based on containers. By default it is
 * possible to subscribe only to users. The container of a release is however
 * a project, so we need to get subscriptions for the project when notifying
 * about a new release.
 *
 * @param string $hook          Hook name
 * @param string $type          Hook type
 * @param array  $subscriptions Array of subscriptions
 * @param array  $params        Hook parameters
 * @return array $subscriptions
 */
function get_release_subscriptions($hook, $type, $subscriptions, $params) {
	$entity = $params['event']->getObject();

	if ($entity instanceof PluginRelease) {
		$project = $entity->getContainerEntity();

		// We skip the first release because we notify about the new plugin project instead
		if ($project->getReleases(array('count' => true)) > 1) {
			$subscriptions += elgg_get_subscriptions_for_container($project->container_guid);
		}
	}

	return $subscriptions;
}


/**
 * Releases are owned by the plugin, so this hook is needed for non-admins
 * To have edit permission on their releases.  Release is editable if the
 * Plugin is editable.
 * 
 * @param type $h
 * @param type $t
 * @param type $r
 * @param array $p
 * @return bool
 */
function release_permissions_check($h, $t, $r, $p) {
	if (!($p['entity'] instanceof PluginRelease)) {
		return $r;
	}
	
	$project = $p['entity']->getContainerEntity();
	return $project->canEdit();
}


/**
 * Add a menu item to the owner block
 *
 * @param string $hook   'register'
 * @param string $type   'menu:owner_block'
 * @param array  $menu   Array of ElggMenu object
 * @param array  $params Hook patameters
 * @return array $menu Array of ElggMenu object
 */
function owner_block_menu($hook, $type, $menu, $params) {
	$user = $params['entity'];

	if (!$user instanceof ElggUser) {
		return $menu;
	}
	
	if (elgg_in_context('plugins')) {
		return array(); // owner block menu causes clutter on these pages
	}
	
	$url = "plugins/search?owner={$user->username}";
	$item = new ElggMenuItem('plugins', elgg_echo('plugins'), $url);
	$menu[] = $item;

	return $menu;
}


/**
 * Populates the ->getUrl() method for plugin releases
 * Redirects to the project page.
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string
 */
function release_url_handler($hook, $type, $url, $params) {
	$release = $params['entity'];

	if (!$release instanceof PluginRelease) {
		return $url;
	}

	$project = $release->getProject();
	if (!$project) {
		error_log("Community plugins: unable to access project for release $release->guid");
		return $url;
	}

	$version = rawurlencode($release->version);
	return  "/plugins/$project->guid/releases/$version";
}


/**
 * Handles plugin project URLs
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string
 */
function project_url_handler($hook, $type, $url, $params) {
	$project = $params['entity'];

	if (!$project instanceof PluginProject) {
		return $url;
	}

    return "/plugins/$project->guid";
}


/**
 * Add menu items for the ownership_request annotation
 *
 * @param string $hook
 * @param string $type
 * @param string $menu
 * @param array  $params
 * @return array $menu
 */
function ownership_request_menu($hook, $type, $menu, $params) {
	$annotation = elgg_extract('annotation', $params);

	if ($annotation->name !== 'ownership_request') {
		return $menu;
	}

	$menu[] = ElggMenuItem::factory(array(
		'name' => 'approve_ownership_request',
		'text' => elgg_echo('approve'),
		'href' => "action/plugins/admin/transfer?project_guid={$annotation->entity_guid}&members[]={$annotation->owner_guid}",
		'link_class' => 'elgg-button elgg-button-action',
		'is_action' => true,
	));

	return $menu;
}


/**
 * Plugin project search hook
 *
 * @param string $hook
 * @param string $type
 * @param <type> $value
 * @param <type> $params
 * @return array
 */
function search_hook($hook, $type, $value, $params) {
	global $CONFIG;
	$query = sanitise_string($params['query']);

	$join = "JOIN {$CONFIG->dbprefix}objects_entity oe ON e.guid = oe.guid";
	$params['joins'] = array($join);
	$params['joins'][] = "JOIN {$CONFIG->dbprefix}metadata summary_md on e.guid = summary_md.entity_guid";
	$params['joins'][] = "JOIN {$CONFIG->dbprefix}metastrings summary_msn on summary_md.name_id = summary_msn.id";
	$params['joins'][] = "JOIN {$CONFIG->dbprefix}metastrings summary_msv on summary_md.value_id = summary_msv.id";

	$fields = array('title', 'description');
	$where = search_get_where_sql('oe', $fields, $params);

	// cheat and use LIKE for the summary field
	// this is kinda dirty.
	$likes = array();
	$query_arr = explode(' ', $query);
	foreach ($query_arr as $word) {
		$likes[] = "summary_msv.string LIKE \"%$word%\"";
	}
	$like_str = implode(' OR ', $likes);

	//$params['wheres'] = array("($where OR ($like_str))");
	$params['wheres'] = array($where);

//	If metastrings were fulltext'd we could do this :(
//	$select = "summary_msv.string summary_string";
//	$params['selects'] = array($select);
//
//	$fields = array('string');
//	$summary_where = search_get_where_sql('summary_msv', $fields, $params);
//	$params['wheres'][] = $summary_where;

	if (($category = get_input('category')) && ($category != 'all')) {
		$params['metadata_name_value_pair'] = array ('name' => 'plugincat', 'value' => $category, 'case_sensitive' => FALSE);
	}
	$params['order_by'] = search_get_order_by_sql('e', 'oe', $params['sort'], $params['order']);


	$entities = elgg_get_entities_from_metadata($params);
	$params['count'] = TRUE;
	$count = elgg_get_entities_from_metadata($params);

	// no need to continue if nothing here.
	if (!$count) {
		return array('entities' => array(), 'count' => $count);
	}

	// add the volatile data for why these entities have been returned.
	foreach ($entities as $entity) {
		$title = search_get_highlighted_relevant_substrings($entity->title, $params['query']);
		$entity->setVolatileData('search_matched_title', $title);

		$desc = search_get_highlighted_relevant_substrings($entity->summary, $params['query']);
		$entity->setVolatileData('search_matched_description', $desc);
	}

	return array(
		'entities' => $entities,
		'count' => $count,
	);
}


/**
 * Nightly update on download counts
 *
 * Adds 1.2M to the figure to account for downloads before this system as implemented.
 */
function update_download_counts() {
	$options = array(
		'type' => 'object',
		'subtype' => 'plugin_release',
		'annotation_name' => 'download',
		'count' => true,
	);
	$count = elgg_get_annotations($options);
	$count += 1200000;
	elgg_set_plugin_setting('site_plugins_downloads', $count, 'community_plugins');
}


function project_comments($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'object', 'plugin_project')) {
		return false;
	}
	
	return $return;
}