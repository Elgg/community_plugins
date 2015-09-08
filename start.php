<?php
/**
 * Elgg community plugin repository
 *
 */

namespace Elgg\CommunityPlugins;

require_once __DIR__ . '/lib/events.php';
require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/lib/page_handlers.php';

define('PLUGINS_CONTRIBUTOR_RELATIONSHIP', 'plugin_contributor');

const PLUGIN_ID = 'community_plugins';
const UPGRADE_VERSION = 20141125;

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

/**
 * Initialize the community plugin repository plugin
 */
function init() {
	elgg_register_library('plugins:upgrades', __DIR__ . '/lib/upgrades.php');
	
	register_js();

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

	
	/**
	 * Extend views
	 */
	// Extend CSS and JS
	elgg_extend_view('elgg.css', 'plugins/css');
	elgg_extend_view('css/admin', 'plugins/admin_css');

	// Extend hover-over and profile menu
	elgg_extend_view('profile/menu/links', 'plugins/profile_menu');
	elgg_extend_view('groups/left_column', 'plugins/groupprofile_files');

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('plugins', __NAMESPACE__ . '\\plugins_page_handler');

	// Tell core to send notifications when new projects and releases are created
	elgg_register_notification_event('object', 'plugin_project', array('create'));
	elgg_register_notification_event('object', 'plugin_release', array('create'));

	
	/**
	 * Register Hooks
	 */
	// The notifications for projects and releases are almost identical so we can use the same handler for both
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:plugin_project', __NAMESPACE__ . '\\prepare_notification');
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:plugin_release', __NAMESPACE__ . '\\prepare_notification');

	// Releases are contained by a project so we need to get the notification subscriptions manually
	elgg_register_plugin_hook_handler('get', 'subscriptions', __NAMESPACE__ . '\\get_release_subscriptions');
	
	// Make sure Releases are editable
	elgg_register_plugin_hook_handler('permissions_check', 'object', __NAMESPACE__ . '\\release_permissions_check');
	
	// make projects non-commentable in the river
	elgg_register_plugin_hook_handler('permissions_check:comment', 'object', __NAMESPACE__ . '\\project_comments');

	// manage owner block menu
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', __NAMESPACE__ . '\\owner_block_menu');
	
	// register url handlers for the 2 object subtypes
	elgg_register_plugin_hook_handler('entity:url', 'object', __NAMESPACE__ . '\\release_url_handler');
	elgg_register_plugin_hook_handler('entity:url', 'object', __NAMESPACE__ . '\\project_url_handler');

	elgg_register_plugin_hook_handler('register', 'menu:annotation', __NAMESPACE__ . '\\ownership_request_menu');
	
	// Special hook for searching against metadata (category)
	elgg_register_plugin_hook_handler('search', 'object:plugin_project', __NAMESPACE__ . '\\search_hook');

	elgg_register_plugin_hook_handler('cron', 'daily', __NAMESPACE__ . '\\update_download_counts');
	

	/**
	 * Register Events
	 */
	elgg_register_event_handler('pagesetup', 'system', __NAMESPACE__ . '\\add_submenus');
	elgg_register_event_handler('upgrade', 'system', __NAMESPACE__ . '\\upgrades');
	elgg_register_event_handler('create', 'object', __NAMESPACE__ . '\\release_comment_notification');
	elgg_register_event_handler('update', 'object', __NAMESPACE__ . '\\project_update');
	
	//register a widget
	elgg_register_widget_type('plugins', elgg_echo('plugins'), elgg_echo('plugins'), array('profile'));


	// Only projects should show up in search
	elgg_register_entity_type('object', 'plugin_project');


	// Elgg versions (The forms expect this to be an associative array)
	elgg_set_config('elgg_versions', array(
		'2.0' => '2.0',
		'1.12' => '1.12',
		'1.11' => '1.11',
		'1.10' => '1.10',
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
		'lgpl2.1' => 'GNU Lesser General Public License (LGPL) version 2.1',
		'berkeleydb' => 'Berkeley Database License (aka the Sleepycat Software Product License)',
		'mbsd' => 'Modified BSD license',
		'cbsd' => 'The Clear BSD License',
		'expat' => 'Expat (MIT) License',
		'freebsd' => 'FreeBSD license',
		'intel' => 'Intel Open Source License',
		'openbsd' => 'ISC (OpenBSD) License',
		'ncsa' => 'NCSA/University of Illinois Open Source License',
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

	
	/**
	 * Register actions
	 */
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
	
	elgg_register_ajax_view('object/plugin_project/release_table');
}
