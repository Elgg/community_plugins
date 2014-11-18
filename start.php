<?php
/**
 * Elgg community plugin repository
 *
 */

define('PLUGINS_CONTRIBUTOR_RELATIONSHIP', 'plugin_contributor');

elgg_register_event_handler('init', 'system', 'plugins_init');

require_once(dirname(__FILE__) . '/lib/plugin_functions.php');

/**
 * Initialize the community plugin repository plugin
 */
function plugins_init() {
	elgg_register_library('plugins:upgrades', __DIR__ . '/lib/upgrades.php');
	
	elgg_register_js('elgg.communityPlugins', '/mod/community_plugins/js/communityPlugins.js', 'footer');
	elgg_register_js('elgg.communityPlugins.filters', '/mod/community_plugins/js/communityPlugins/filters.js', 'footer');
	elgg_register_js('jquery.flot', '/mod/community_plugins/vendors/flot/jquery.flot.js', 'footer');
	
	elgg_register_js('jquery.chosen', '/mod/community_plugins/vendors/chosen/chosen.jquery.min.js', 'footer');
	elgg_register_css('jquery.chosen', '/mod/community_plugins/vendors/chosen/chosen.min.css');

	// Set up menu for logged in users
	elgg_register_menu_item('site', array(
		'href' => "/plugins",
		'name' => 'plugins',
		'text' => elgg_echo('plugins'),
	));

	elgg_register_menu_item('site', array(
		'href' => '/plugins/category/themes',
		'name' => 'themes',
		'text' => elgg_echo('plugins:type:theme'),
	));

	// Extend CSS and JS
	elgg_extend_view('css', 'plugins/css');
	elgg_extend_view('css/admin', 'plugins/admin_css');

	// Extend hover-over and profile menu
	elgg_extend_view('profile/menu/links', 'plugins/profile_menu');
	elgg_extend_view('groups/left_column', 'plugins/groupprofile_files');

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('plugins', 'plugins_page_handler');

	// Image handler
	elgg_register_page_handler('plugins_image', 'plugins_image_page_handler');

	// Tell core to send notifications when new projects and releases are created
	elgg_register_notification_event('object', 'plugin_project', array('create'));
	elgg_register_notification_event('object', 'plugin_release', array('create'));

	// The notifications for projects and releases are almost identical so we can use the same handler for both
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:plugin_project', 'plugins_prepare_notification');
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:plugin_release', 'plugins_prepare_notification');

	// Releases are contained by a project so we need to get the notification subscriptions manually
	elgg_register_plugin_hook_handler('get', 'subscriptions', 'plugins_get_release_subscriptions');
	
	// Make sure Releases are editable
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'plugins_release_permissions_check');

	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'plugins_owner_block_menu');

	//register a widget
	elgg_register_widget_type('plugins', elgg_echo('plugins'), elgg_echo('plugins'), array('profile'));

	// register url handlers for the 2 object subtypes
	elgg_register_plugin_hook_handler('entity:url', 'object', 'plugins_release_url_handler');
	elgg_register_plugin_hook_handler('entity:url', 'object', 'plugins_project_url_handler');

	elgg_register_plugin_hook_handler('register', 'menu:annotation', 'plugins_ownership_request_menu');

	elgg_register_event_handler('pagesetup', 'system', 'plugins_add_submenus');

	// Only projects should show up in search
	elgg_register_entity_type('object', 'plugin_project');

	// Special hook for searching against metadata (category)
	elgg_register_plugin_hook_handler('search', 'object:plugin_project', 'plugins_search_hook');

	elgg_register_plugin_hook_handler('cron', 'daily', 'plugins_update_download_counts');

	// Elgg versions (The forms expect this to be an associative array)
	elgg_set_config('elgg_versions', array(
		'1.9' => '1.9',
		'1.8' => '1.8',
		'1.7' => '1.7',
		'1.6' => '1.6',
		'1.5' => '1.5',
		'1.2' => '1.2',
		'1.0' => '1.0',
	));

	// GPL-compatible licenses
	elgg_set_config('gpllicenses', array(
		'none' => 'No license selected',
		'gpl2' => 'GNU General Public License (GPL) version 2',
		//'gpl3' => 'GNU General Public License (GPL) version 3',
		//'lgpl3' => 'GNU Lesser General Public License (LGPL) version 3',
		'lgpl2.1' => 'GNU Lesser General Public License (LGPL) version 2.1',
		//'apache' => 'Apache License, Version 2.0',
		//'artistic' => 'Artistic License 2.0',
		//'artistic' => 'Clarified Artistic License',
		'berkeleydb' => 'Berkeley Database License (aka the Sleepycat Software Product License)',
		//'boost' => 'Boost Software License',
		'mbsd' => 'Modified BSD license',
		'cbsd' => 'The Clear BSD License',
		//'cecill' => 'CeCILL version 2',
		//'cryptix' => 'Cryptix General License',
		//'ecos' => 'eCos license version 2.0',
		//'edu' => 'Educational Community License 2.0',
		//'eiffel' => 'Eiffel Forum License, version 2',
		//'eudatagrid' => 'EU DataGrid Software License',
		'expat' => 'Expat (MIT) License',
		'freebsd' => 'FreeBSD license',
		//'freetype' => 'Freetype Project License',
		//'jpeg' => 'Independent JPEG Group License',
		'intel' => 'Intel Open Source License',
		'openbsd' => 'ISC (OpenBSD) License',
		'ncsa' => 'NCSA/University of Illinois Open Source License',
		//'public' => 'Public Domain',
		//'sgi' => 'SGI Free Software License B, version 2.0',
		'w3c' => 'W3C Software Notice and License',
		'x11' => 'X11 License',
		'zope' => 'Zope Public License, versions 2.0 and 2.1',
	));

	// Defined plugin categories
	elgg_set_config('plugincats', array(
		'admin' => 'Site admin',
		'user' => 'User admin',
		'authentication' => 'Authentication',
		'tools' => 'Tools',
		'spam' => 'Spam',
		'communication' => 'Communication',
		//'core' => 'Core Enhancements',
		'events' => 'Events',
		'media' => 'Media',
		'photos' => 'Photos and Images',
		'tpintegrations' => 'Third Party integrations',
		'clients' => 'Clients',
		'widgets' => 'Widgets',
		'games' => 'Games',
		'ecommerce' => 'eCommerce',
		'languages' => 'Language packs',
		'themes' => 'Themes',
		'misc' => 'Misc',
		'uncategorized' => 'Uncategorized',
	));

	$action_base = dirname(__FILE__) . "/actions/plugins";
	elgg_register_action("plugins/create_project", "$action_base/create_project.php");
	elgg_register_action("plugins/create_release", "$action_base/create_release.php");
	elgg_register_action("plugins/save_project", "$action_base/save_project.php");
	elgg_register_action("plugins/save_release", "$action_base/save_release.php");
	elgg_register_action("plugins/delete_project", "$action_base/delete_project.php");
	elgg_register_action("plugins/delete_release", "$action_base/delete_release.php");
	elgg_register_action("plugins/delete_project_image", "$action_base/delete_project_image.php");
	elgg_register_action("plugins/recommend", "$action_base/recommend.php");
	elgg_register_action("plugins/add_contributors", "$action_base/add_contributors.php");
	elgg_register_action("plugins/delete_contributor", "$action_base/delete_contributor.php");
	elgg_register_action("plugins/request_ownership", "$action_base/request_ownership.php");

	elgg_register_action("plugins/admin/upgrade", "$action_base/admin/upgrade.php", 'admin');
	elgg_register_action("plugins/admin/combine", "$action_base/admin/combine.php", 'admin');
	elgg_register_action("plugins/admin/normalize", "$action_base/admin/normalize.php", 'admin');
	elgg_register_action("plugins/admin/search", "$action_base/admin/search.php", 'admin');
	elgg_register_action("plugins/admin/transfer", "$action_base/admin/transfer.php", 'admin');

	elgg_register_tag_metadata_name('plugin_type');
	
	if (elgg_is_admin_logged_in()) {
		elgg_register_event_handler('upgrade', 'system', 'plugins_upgrades');
	}
}

/**
 * Sets up submenus. Triggered on pagesetup.
 *
 */
function plugins_add_submenus() {

	$plugins_base = elgg_get_site_url() . "plugins";

	if (elgg_get_context() == 'admin') {
		elgg_register_admin_menu_item('administer', 'upgrade', 'community_plugins');
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
 * Add a menu item to the owner block
 *
 * @param string $hook   'register'
 * @param string $type   'menu:owner_block'
 * @param array  $menu   Array of ElggMenu object
 * @param array  $params Hook patameters
 * @return array $menu Array of ElggMenu object
 */
function plugins_owner_block_menu($hook, $type, $menu, $params) {
	$user = $params['entity'];

	if (!$user instanceof ElggUser) {
		return $menu;
	}

	$url = "plugins/search?owner={$user->username}";
	$item = new ElggMenuItem('plugins', elgg_echo('plugins'), $url);
	$menu[] = $item;

	return $menu;
}


/**
 * Plugins page handler
 *
 * @param array $page Array of page elements
 */
function plugins_page_handler($segments) {
	$urls = array(
		"plugins/contributors" => "/plugins/{plugin}/contributors",
		"plugins/developer" => "/users/{developer}/plugins",
		"plugins/edit" => "/plugins/{plugin}/edit",
		"plugins/icon" => "/plugins/{plugin}/icons/{icon}.jpg",
		"plugins/index" => "/plugins",
		"plugins/list/{type}",
		"plugins/new" => "/plugins/new",
		"plugins/search" => "/plugins/search",
		"plugins/transfer" => "/plugins/{plugin}/transfer",
		"plugins/view" => "/plugins/{plugin}",
		"plugins/releases/index" => "/plugins/{plugin}/releases",
		"plugins/releases/download" => "/plugins/{plugin}/releases/{release}/download",
		"plugins/releases/edit" => "/plugins/{plugin}/releases/{release}/edit",
		"plugins/releases/new" => "/plugins/{plugin}/releases/new",
		"plugins/releases/view" => "/plugins/{plugin}/releases/{version}",
		"plugins/screenshots/index" => "/plugins/{plugin}/screenshots",
		"plugins/screenshots/view" => "/plugins/{plugin}/screenshots/{screenshot}.jpg",
		"plugins/ownership_request" => "/plugins/{plugin}/ownership_request",
		"plugins/ownership_requests" => "/plugins/{plugin}/ownership_requests",
	);

	$forwards = array(
		"/plugins/all" => function() {
			forward("/plugins");
		},
		"/plugins/category/{category}" => function() {
			$category = get_input('category');
			forward("/plugins/search?category=$category");
		},
		"/plugins/contributors/{plugin}" => function() {
			$plugin = get_input('plugin');
			forward("/plugins/$plugin/contributors");
		},
		"/plugins/developer/{developer}" => function() {
			$developer = get_input('developer');
			forward("/plugins/search?owner=$developer");
		},
		"/plugins/developer/{developer}/type/{type}" => function() {
			$developer = get_input('developer');
			$type = get_input('type');
			forward("/plugins/search?owner=$developer&type=$type");
		},
		"/plugins/download/{release}" => function() {
			$release = get_entity(get_input('release'));
			$plugin = $release->getProject();
			forward("/plugins/{$plugin->guid}/releases/{$release->version}/download");
		},
		"/plugins/edit/project/{plugin}" => function() {
			$plugin = get_input('plugin');
			forward("/plugins/$plugin/edit");
		},
		"/plugins/edit/release/{release}" => function() {
			$release = get_entity(get_input('release'));
			$plugin = $release->getProject();
			forward("/plugins/{$plugin->guid}/releases/{$release->version}");
		},
		"/plugins/icon/{guid}/icon.jpg" => function() {
			$icon = get_input('guid');
			$plugin = get_entity($icon)->getContainerGuid();
			forward("/plugins/$plugin/icons/$icon.jpg");
		},
		"/plugins/new/project/{username}" => function() {
			forward("/plugins/new");
		},
		"/plugins/new/release/{plugin}" => function() {
			$plugin = get_input('plugin');
			forward("/plugins/$plugin/releases/new");
		},
		"/plugins/project/{plugin}" => function() {
			$plugin = get_input('plugin');
			forward("/plugins/$plugin");
		},
		"/plugins/release/{release}" => function() {
			$release = get_entity(get_input('release'));
			$plugin = $release->getProject();
			forward("/plugins/{$plugin->guid}/releases/{$release->version}");
		},
		"/plugins/transfer/{plugin}" => function() {
			$plugin = get_input('plugin');
			forward("/plugins/$plugin/transfer");
		},
		"/plugins/list/{type}" => function() {
			
			include __DIR__ . '/pages/plugins/list.php';
			return true;
		},
		"/plugins/{guid}/{release}/{title}" => function() {
			$plugin = get_input('guid');
			$release = get_input('release');

			forward("/plugins/$plugin/releases/$release");
		},
		"/plugins/{guid}/{release}" => function() {
			$plugin = get_input('guid');
			$release = get_input('release');

			forward("/plugins/$plugin/releases/$release");
		},
		"/plugins/{username}/read/{plugin}/{title}" => function() {
			$plugin = get_input('plugin');
			forward("/plugins/$plugin");
		},
		"/plugins_image/{guid}/{timestamp}.jpg" => function() {
			$screenshot = get_entity(get_input('guid'));
			$plugin = $screenshot->getContainerEntity();
			$timestamp = $screenshot->time_created;
			forward("/plugins/$plugin/screenshots/$screenshot.$timestamp.jpg");
		},
	);

	array_unshift($segments, 'plugins');
	$path = "/" . implode("/", $segments);
	$plugin_dir = dirname(__FILE__);
	$pages_dir = "$plugin_dir/pages";

	foreach($urls as $state => $template_str) {
		$template = new Elgg\CommunityPlugins\UriTemplate($template_str);

		$result = $template->match($path);
		if ($result !== null) {
			foreach ($result as $name => $value) {
				set_input($name, $value);
			}

			include_once("$pages_dir/$state.php");
			return true;
		}
	}

	foreach($forwards as $template_str => $callback) {
		$template = new Elgg\CommunityPlugins\UriTemplate($template_str);
		$result = $template->match($path);
		if ($result !== null) {
			foreach ($result as $name => $value) {
				set_input($name, $value);
			}

			$callback();
			return true;
		}
	}

	return false;
}

/**
 * Serve up /plugins_image/{image}/{timestamp}.jpg
 *
 * @param array $page
 * @return void
 */
function plugins_image_page_handler($page) {
	// fileguid/createtime.jpg
	$icon_guid = $page[0];
	$plugin_guid = get_entity($icon_guid)->getContainerGuid();

	forward("/plugins/$plugin_guid/icons/$icon_guid.jpg");
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
function plugins_project_url_handler($hook, $type, $url, $params) {
	$project = $params['entity'];

	if (!$project instanceof PluginProject) {
		return $url;
	}

    return "/plugins/$project->guid";
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
function plugins_release_url_handler($hook, $type, $url, $params) {
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
 * Add a sidebar menu of plugin types for this developer
 *
 * @param int $owner_guid The GUID of the owner of the plugins
 */
function plugins_add_type_menu($owner_guid) {
	$owner = get_entity($owner_guid);
	if (!$owner) {
		return;
	}

	$plugin_types = elgg_get_tags(array(
		'threshold' => 0,
		'limit' => 10,
		'tag_names' => array('plugin_type'),
		'type' => 'object',
		'subtype' => 'plugin_project',
		'container_guid' => $owner_guid,
	));

	if ($plugin_types) {
		foreach ($plugin_types as $type) {

			$tag = $type->tag;
			$label = elgg_echo("plugins:type:" . $tag);

			$url = "/plugins/developer/$owner->username/type/$tag/";

			elgg_register_menu_item('page', array('name' => $label, 'text' => $label, 'href' => $url));
		}
	}
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
function plugins_ownership_request_menu($hook, $type, $menu, $params) {
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
 * Nightly update on download counts
 *
 * Adds 1.2M to the figure to account for downloads before this system as implemented.
 */
function plugins_update_download_counts() {
	$options = array(
		'type' => 'object',
		'subtype' => 'plugin_project',
		'annotation_name' => 'download',
		'count' => true,
	);
	$count = elgg_get_annotations($options);
	$count += 1200000;
	elgg_set_plugin_setting('site_plugins_downloads', $count, 'community_plugins');
}

/**
 * Prepare a notification message about a new plugin project or a new plugin release
 *
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg_Notifications_Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg_Notifications_Notification
 */
function plugins_prepare_notification($hook, $type, $notification, $params) {
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
function plugins_get_release_subscriptions($hook, $type, $subscriptions, $params) {
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
function plugin_release_permissions_check($h, $t, $r, $p) {
	if (!($p['entity'] instanceof PluginRelease)) {
		return $r;
	}
	
	$project = $p['entity']->getContainerEntity();
	return $project->canEdit();
}


function plugins_upgrades() {
	elgg_load_library('plugins:upgrades');
	run_function_once('plugins_upgrade_20141107');
}