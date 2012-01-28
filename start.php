<?php
/**
 * Elgg community plugin repository
 * 
 */

elgg_register_event_handler('init', 'system', 'plugins_init');

require_once(dirname(__FILE__) . '/lib/plugin_functions.php');

/**
 * Initialize the community plugin repository plugin
 */
function plugins_init() {
	global $CONFIG;

	run_function_once('plugins_run_once');
	run_function_once('plugins_create_download_table');

	// Set up menu for logged in users
	add_menu(elgg_echo('plugins'), "/plugins/all");

	// Extend CSS and JS
	elgg_extend_view('css', 'plugins/css');
	elgg_extend_view('js/initialise_elgg', 'plugins/js');
	elgg_extend_view('page/elements/head', 'plugins/metatags');

	// Extend hover-over and profile menu
	elgg_extend_view('profile/menu/links', 'plugins/profile_menu');
	elgg_extend_view('groups/left_column', 'plugins/groupprofile_files');

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('plugins', 'plugins_page_handler');

	// Image handler
	elgg_register_page_handler('plugins_image', 'plugins_image_page_handler');

	register_notification_object('object', 'plugins', elgg_echo('plugins:new'));

	//register a widget
	elgg_register_widget_type('plugins', elgg_echo('plugins'), elgg_echo('plugins'), 'profile');


	// register url handlers for the 2 object subtypes
	elgg_register_entity_url_handler('plugins_release_url_handler', 'object', 'plugin_release');
	elgg_register_entity_url_handler('plugins_project_url_handler', 'object', 'plugin_project');

	elgg_register_event_handler('pagesetup', 'system', 'plugins_add_submenus');

	// Only projects should show up in search
	elgg_register_entity_type('object', 'plugin_project');

	// Special hook for searching against metadata (category)
	elgg_register_plugin_hook_handler('search', 'object:plugin_project', 'plugins_search_hook');

	elgg_register_plugin_hook_handler('cron', 'daily', 'plugins_update_download_counts');

	// Elgg versions
	$CONFIG->elgg_versions = array(
		'1.8',
		'1.7',
		'1.6',
		'1.5',
		'1.2',
		'1.0'
	);

	// GPL-compatible licenses
	$CONFIG->gpllicenses = array(
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
	);

	// Defined plugin categories
	$CONFIG->plugincats = array(
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
	);

	$action_base = "{$CONFIG->pluginspath}community_plugins/actions/plugins";
	elgg_register_action("plugins/create_project", "$action_base/create_project.php");
	elgg_register_action("plugins/create_release", "$action_base/create_release.php");
	elgg_register_action("plugins/save_project", "$action_base/save_project.php");
	elgg_register_action("plugins/save_release", "$action_base/save_release.php");
	elgg_register_action("plugins/delete_project", "$action_base/delete_project.php");
	elgg_register_action("plugins/delete_release", "$action_base/delete_release.php");
	elgg_register_action("plugins/delete_project_image", "$action_base/delete_project_image.php");
	elgg_register_action("plugins/recommend", "$action_base/recommend.php");

	elgg_register_action("plugins/upgrade", "$action_base/admin/upgrade.php", 'admin');
	elgg_register_action("plugins/combine", "$action_base/admin/combine.php", 'admin');
	elgg_register_action("plugins/normalize", "$action_base/admin/normalize.php", 'admin');
	elgg_register_action("plugins/admin/search", "$action_base/admin/save.php", 'admin');
}

/**
 * Register classes for loading by Elgg when loading an entity
 */
function plugins_run_once() {
	add_subtype("object", "plugin_release", "PluginRelease");
	add_subtype("object", "plugin_project", "PluginProject");
}

/**
 * Sets up submenus. Triggered on pagesetup.
 *
 */
function plugins_add_submenus() {
	global $CONFIG;

	$plugins_base = elgg_get_site_url() . "plugins";

	if (elgg_get_context() == 'admin') {
		$title = elgg_echo("plugins:admin:menu");
		add_submenu_item($title, "$plugins_base/admin/");
		return;
	}

	if (elgg_get_context() != "plugins") {
		return;
	}

	$page_owner = elgg_get_page_owner_entity();

	if (elgg_is_logged_in() && elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
		$title = sprintf(elgg_echo("plugins:yours"), elgg_echo('plugins:types:'));
		add_submenu_item($title, "$plugins_base/developer/$page_owner->username");
	} else if (elgg_get_page_owner_guid()) {
		$title = sprintf(elgg_echo("plugins:user"), $page_owner->name, elgg_echo('plugins:types:'));
		add_submenu_item($title, "$plugins_base/developer/$page_owner->username");
	}

	add_submenu_item(elgg_echo('plugins:all'), "$plugins_base/all");

	// add upload link when viewing own plugin page
	if (elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) {
		add_submenu_item(elgg_echo('plugins:upload'), "$plugins_base/new/project/$page_owner->username");
	}
}

/**
 * Plugins page handler
 *
 * @param array $page Array of page elements
 */
function plugins_page_handler($page) {

	global $CONFIG;

	$plugin_dir = $CONFIG->pluginspath . "community_plugins/pages/plugins";

	if (!isset($page[0])) {
		// bad url - we'll send to main plugin page
		$page[0] = 'all';
	}

	switch($page[0]) {
		// plugin repository front page
		case "all":
			include("$plugin_dir/all.php");
			break;
		// category listing page (deprecated, just preserved for compatibility and old bookmarks' sake)
		case "category":
			set_view_location('entities/entity_list', $CONFIG->pluginspath . "community_plugins/views/override/");
			set_input('category', $page[1]);
			include("$plugin_dir/category_list.php");
			break;
		// New advanced search page (with filtering and sorting)
		case "search":
			set_view_location('entities/entity_list', $CONFIG->pluginspath . "community_plugins/views/override/");
			include("$plugin_dir/search.php");
			break;
			// list a developer's plugins
		case "developer":
			set_input('username', $page[1]);
			if (isset($page[2])) {
				set_input($page[2], $page[3]);
			}
			include("$plugin_dir/developer.php");
			break;
		case "download":
			// download/<release_guid>/
			set_input('release_guid', $page[1]);
			include("$plugin_dir/download.php");
			break;
		// view plugin project
		case "project":
			set_input('guid', $page[1]);
			include("$plugin_dir/read.php");
			break;
		// view specfic release of a project
		case "release":
			set_input('release', $page[1]);
			include("$plugin_dir/read.php");
			break;
		// create new plugin project or release
		case "new":
			if ($page[1] == 'release') {
				// new/release/<project guid>/
				set_input('project_guid', $page[2]);
				include("$plugin_dir/create_release.php");
			} else {
				// new/project/<username>/
				set_input('username', $page[2]);
				include("$plugin_dir/create_project.php");
			}
			break;
		// edit plugin project or release
		case 'edit':
			if ($page[1] == 'release') {
				// edit/release/<release guid>/
				set_input('release_guid', $page[2]);
				include("$plugin_dir/edit_release.php");
			} else {
				// edit/project/<project guid>/
				set_input('project_guid', $page[2]);
				include("$plugin_dir/edit_project.php");
			}
			break;
		// admin page
		case "admin":
			set_input('tab', $page[1]);
			include("$plugin_dir/admin.php");
			break;
		// for backwards compatibility this handles /plugins/<username>/read/<guid>/<title>
		default:
			set_input('guid', $page[2]);
			include("$plugin_dir/read.php");
			break;
	}

	return TRUE;
}

/**
 * Serve up image.
 *
 * @param unknown_type $page
 * @return unknown_type
 */
function plugins_image_page_handler($page) {
	// fileguid/createtime.jpg
	if (!is_array($page) || !array_key_exists(0, $page) || !array_key_exists(1, $page)) {
		exit;
	}

	if (!($file = get_entity($page[0])) || !($file instanceof ElggFile)
	|| !($time = str_replace('.jpg', '', strtolower($page[1])))
	|| ($file->time_created != $time)) {
		exit;
	}

	$contents = $file->grabFile();
	header('Expires: ' . date('r', time() + 60*60*24*7));
	header('Pragma: public');
	header('Cache-Control: public');
	header("Content-Disposition: inline; filename=\"{$file->originalfilename}\"");
	header("Content-type: {$mime}");
	header("Content-Length: " . strlen($contents));

	$split_output = str_split($contents, 1024);
	foreach($split_output as $chunk) {
		echo $chunk;
	}

	exit;
}

/**
 * Handles plugin project URLs
 *
 * @param ElggEntity $entity
 * @return string
 */
function plugins_project_url_handler($entity) {
	$title = elgg_get_friendly_title($entity->title);

	return "/plugins/project/{$entity->getGUID()}/developer/{$entity->getOwnerEntity()->username}/$title";
}

/**
 * Populates the ->getUrl() method for plugin releases
 * Redirects to the project page.
 *
 * @param ElggEntity $entity 
 * @return string
 */
function plugins_release_url_handler($entity) {
	$title = elgg_get_friendly_title($entity->title);

	return "/plugins/release/$entity->guid/developer/{$entity->getOwnerEntity()->username}/$title";
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

	$plugin_types = get_tags(0, 10, 'plugin_type', 'object', 'plugin_project', $owner_guid);

	if ($plugin_types) {
		foreach ($plugin_types as $type) {

			$tag = $type->tag;
			$label = elgg_echo("plugins:type:" . $tag);

			$url = "/plugins/developer/$owner->username/type/$tag/";

			add_submenu_item($label, $url, 'pluginstypes');
		}
	}
}

/**
 * Nightly update on download counts
 *
 * Adds 1.2M to the figure to account for downloads before this system as implemented.
 */
function plugins_update_download_counts() {
	$count = count_annotations(0, 'object', 'plugin_project', 'download', '', NULL);
	$count += 1200000;
	set_plugin_setting('site_plugins_downloads', $count, 'community_plugins');
}

/**
 * Creates the table for the plugin download count
 */
function plugins_create_download_table() {
	$db_prefix = get_config('dbprefix');
	$sql = "CREATE TABLE `{$db_prefix}plugin_downloads` (
		`guid` BIGINT UNSIGNED NOT NULL,
		`downloads` INT UNSIGNED NOT NULL DEFAULT 0,
		PRIMARY KEY (`guid`),
		KEY `downloads` (`downloads`)
	) ENGINE=MyISAM";

	get_data($sql);
}
