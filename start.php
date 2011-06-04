<?php
/**
 * Elgg community plugin repository
 * 
 */

register_elgg_event_handler('init', 'system', 'plugins_init');

require_once(dirname(__FILE__) . '/lib/plugin_functions.php');
require_once(dirname(__FILE__) . '/classes/PluginRelease.php');
require_once(dirname(__FILE__) . '/classes/PluginProject.php');

/**
 * Initialize the community plugin repository plugin
 */
function plugins_init() {
	global $CONFIG;

	run_function_once('plugins_run_once');

	// Set up menu for logged in users
	add_menu(elgg_echo('plugins'), "{$CONFIG->wwwroot}pg/plugins/all/");

	// Extend CSS
	extend_view('css', 'plugins/css');

	// Extend hover-over and profile menu
	extend_view('profile/menu/links', 'plugins/profile_menu');
	extend_view('groups/left_column', 'plugins/groupprofile_files');

	// Register a page handler, so we can have nice URLs
	register_page_handler('plugins', 'plugins_page_handler');

	// Image handler
	register_page_handler('plugins_image', 'plugins_image_page_handler');

	register_notification_object('object', 'plugins', elgg_echo('plugins:new'));

	//register a widget
	add_widget_type('plugins', elgg_echo('plugins'), elgg_echo('plugins'), 'profile');


	// register url handlers for the 2 object subtypes
	register_entity_url_handler('plugins_release_url_handler', 'object', 'plugin_release');
	register_entity_url_handler('plugins_project_url_handler', 'object', 'plugin_project');

	register_elgg_event_handler('pagesetup', 'system', 'plugins_add_submenus');

	// Only projects should show up in search
	register_entity_type('object', 'plugin_project');

	// Special hook for searching against metadata (category)
	register_plugin_hook('search', 'object:plugin_project', 'plugins_search_hook');

	// Elgg versions
	$CONFIG->elgg_versions = array(
		'1.7',
		'1.7a',
		'1.6.1',
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
		'events' => 'Events',
		'authentication' => 'Authentication',
		'clients' => 'Clients',
		//'core' => 'Core Enhancements',
		'photos' => 'Photos and Images',
		'tpintegrations' => 'Third Party integrations',
		'tools' => 'Tools',
		'media' => 'Media',
		'communication' => 'Communication',
		'widgets' => 'Widgets',
		'games' => 'Games',
		'ecommerce' => 'eCommerce',
		'languages' => 'Languages',
		'themes' => 'Themes',
		'misc' => 'Misc',
		'uncategorized' => 'Uncategorized',
	);

	$action_base = "{$CONFIG->pluginspath}community_plugins/actions";
	register_action("plugins/create_project", FALSE, "$action_base/create_project.php");
	register_action("plugins/create_release", FALSE, "$action_base/create_release.php");
	register_action("plugins/save_project", FALSE, "$action_base/save_project.php");
	register_action("plugins/save_release", FALSE, "$action_base/save_release.php");
	register_action("plugins/delete_project", FALSE, "$action_base/delete_project.php");
	register_action("plugins/delete_release", FALSE, "$action_base/delete_release.php");
	register_action("plugins/delete_project_image", FALSE, "$action_base/delete_project_image.php");
	register_action("plugins/digg", FALSE, "$action_base/digg.php");

	register_action("plugins/upgrade", FALSE, "$action_base/upgrade.php", TRUE);
	register_action("plugins/combine", FALSE, "$action_base/admin/combine.php", TRUE);
	register_action("plugins/normalize", FALSE, "$action_base/admin/normalize.php", TRUE);
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

	$plugins_base = "{$CONFIG->wwwroot}pg/plugins";

	if (get_context() == 'admin') {
		$title = elgg_echo("plugins:admin:menu");
		add_submenu_item($title, "$plugins_base/admin/");
		return;
	}

	if (get_context() != "plugins") {
		return;
	}

	$page_owner = page_owner_entity();

	if (isloggedin() && page_owner() == get_loggedin_userid()) {
		$title = sprintf(elgg_echo("plugins:yours"), elgg_echo('plugins:types:'));
		add_submenu_item($title, "$plugins_base/developer/$page_owner->username");
		//add_submenu_item(sprintf(elgg_echo('plugins:yours:friends'),page_owner_entity()->name), $CONFIG->wwwroot . "pg/plugins/". $page_owner->username . "/friends/");
	} else if (page_owner()) {
		$title = sprintf(elgg_echo("plugins:user"), $page_owner->name, elgg_echo('plugins:types:'));
		add_submenu_item($title, "$plugins_base/developer/$page_owner->username");
		//if ($page_owner instanceof ElggUser) // This one's for users, not groups
			//add_submenu_item(sprintf(elgg_echo('plugins:friends'),$page_owner->name), $CONFIG->wwwroot . "pg/plugins/". $page_owner->username . "/friends/");
	}

	add_submenu_item(elgg_echo('plugins:all'), "$plugins_base/all/");

	// add upload link when viewing own plugin page
	if (get_loggedin_userid() == page_owner()) {
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

	$plugin_dir = $CONFIG->pluginspath . "community_plugins/pages/community_plugins";

	if (!isset($page[0])) {
		// bad url - we'll send to main plugin page
		$page[0] = 'all';
	}

	switch($page[0]) {
		// plugin repository front page
		case "all":
			include("$plugin_dir/all.php");
			break;
		// category listing page
		case "category":
			set_input('category', $page[1]);
			include("$plugin_dir/category_list.php");
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
		// for backwards compatibility this handles /pg/plugins/<username>/read/<guid>/<title>
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
	global $CONFIG;

	$title = $entity->title;
	$title = friendly_title($title);
	return $CONFIG->url . "pg/plugins/project/{$entity->getGUID()}/developer/{$entity->getOwnerEntity()->username}/$title";
}

/**
 * Populates the ->getUrl() method for plugin releases
 * Redirects to the project page.
 *
 * @param ElggEntity $entity 
 * @return string
 */
function plugins_release_url_handler($entity) {
	global $CONFIG;

	$title = $entity->title;
	$title = friendly_title($title);
	return $CONFIG->url . "pg/plugins/release/$entity->guid/developer/{$entity->getOwnerEntity()->username}/$title";
}

/**
 * Add a sidebar menu of plugin types for this developer
 *
 * @param int $owner_guid The GUID of the owner of the plugins
 */
function plugins_add_type_menu($owner_guid) {
	global $CONFIG;

	$owner = get_entity($owner_guid);
	if (!$owner) {
		return;
	}

	$plugin_types = get_tags(0, 10, 'plugin_type', 'object', 'plugin_project', $owner_guid);

	foreach ($plugin_types as $type) {

		$tag = $type->tag;
		$label = elgg_echo("plugins:type:" . $tag);

		$url = "{$CONFIG->url}pg/plugins/developer/$owner->username/type/$tag/";

		add_submenu_item($label, $url, 'pluginstypes');
	}
}
