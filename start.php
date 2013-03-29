<?php
/**
 * Elgg community plugin repository
 * 
 */

define(PLUGINS_CONTRIBUTOR_RELATIONSHIP, 'plugin_contributor');

elgg_register_event_handler('init', 'system', 'plugins_init');

require_once(dirname(__FILE__) . '/lib/plugin_functions.php');

/**
 * Initialize the community plugin repository plugin
 */
function plugins_init() {
	elgg_register_js('elgg.communityPlugins', '/mod/community_plugins/js/communityPlugins.js', 'footer');
	elgg_register_js('elgg.communityPlugins.filters', '/mod/community_plugins/js/communityPlugins/filters.js', 'footer');
	elgg_register_js('elgg.communityPlugins.PluginImages', '/mod/community_plugins/js/communityPlugins/PluginImages.js', 'footer');
	elgg_register_js('jquery.flot', '/mod/community_plugins/vendors/flot/jquery.flot.js', 'footer');
	elgg_register_js('jquery.lightbox', '/mod/community_plugins/vendors/jquery.lightbox.js', 'footer');
	elgg_register_js('jquery.ui.dropdownchecklist', '/mod/community_plugins/vendors/dropdown-check-list/ui.dropdownchecklist.js', 'footer');
	elgg_register_css('jquery.ui.dropdownchecklist', '/mod/community_plugins/vendors/dropdown-check-list/ui.dropdownchecklist.standalone.css');

	// TODO(ewinslow): Surely these don't need to go on EVERY page?
	elgg_load_css('jquery.ui.dropdownchecklist');
	elgg_load_js('jquery.ui.dropdownchecklist');
	elgg_load_js('elgg.communityPlugins');

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

	// TODO: This looks like a bug. "plugins" is not a valid subtype
	register_notification_object('object', 'plugins', elgg_echo('plugins:new'));

	//register a widget
	elgg_register_widget_type('plugins', elgg_echo('plugins'), elgg_echo('plugins'), 'profile');


	// register url handlers for the 2 object subtypes
	elgg_register_entity_url_handler('object', 'plugin_release', 'plugins_release_url_handler');
	elgg_register_entity_url_handler('object', 'plugin_project', 'plugins_project_url_handler');

	elgg_register_event_handler('pagesetup', 'system', 'plugins_add_submenus');

	// Only projects should show up in search
	elgg_register_entity_type('object', 'plugin_project');

	// Special hook for searching against metadata (category)
	elgg_register_plugin_hook_handler('search', 'object:plugin_project', 'plugins_search_hook');

	elgg_register_plugin_hook_handler('cron', 'daily', 'plugins_update_download_counts');

	// Elgg versions
	global $CONFIG;
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

	$action_base = dirname(__FILE__) . "/actions/plugins";
	elgg_register_action("plugins/create_project", "$action_base/create_project.php");
	elgg_register_action("plugins/update_project_from_github", "$action_base/update_project_from_github.php");
    elgg_register_action("plugins/create_release", "$action_base/create_release.php");
	elgg_register_action("plugins/save_project", "$action_base/save_project.php");
	elgg_register_action("plugins/save_release", "$action_base/save_release.php");
	elgg_register_action("plugins/delete_project", "$action_base/delete_project.php");
	elgg_register_action("plugins/delete_release", "$action_base/delete_release.php");
	elgg_register_action("plugins/delete_project_image", "$action_base/delete_project_image.php");
	elgg_register_action("plugins/recommend", "$action_base/recommend.php");
	elgg_register_action("plugins/add_contributors", "$action_base/add_contributors.php");
	elgg_register_action("plugins/delete_contributor", "$action_base/delete_contributor.php");

	elgg_register_action("plugins/admin/upgrade", "$action_base/admin/upgrade.php", 'admin');
	elgg_register_action("plugins/admin/combine", "$action_base/admin/combine.php", 'admin');
	elgg_register_action("plugins/admin/normalize", "$action_base/admin/normalize.php", 'admin');
	elgg_register_action("plugins/admin/search", "$action_base/admin/search.php", 'admin');
	elgg_register_action("plugins/admin/transfer", "$action_base/admin/transfer.php", 'admin');
	
	elgg_register_tag_metadata_name('plugin_type');
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
 * Plugins page handler
 *
 * @param array $page Array of page elements
 */
function plugins_page_handler($page) {
	$plugin_dir = dirname(__FILE__);
	$pages_dir = "$plugin_dir/pages/plugins";

	switch ($page[0]) {
		// plugin repository front page
		case "all":
			system_message('Please update your bookmark or report this link to the site owner as this page has moved.');
			header('Location: /plugins', true, 301);
			break;
		// category listing page (deprecated, just preserved for compatibility and old bookmarks' sake)
		case "category":
			elgg_set_view_location('entities/entity_list', "$plugin_dir/views/override/");
			set_input('category', $page[1]);
			include("$pages_dir/category_list.php");
			break;
		// New advanced search page (with filtering and sorting)
		case "search":
			elgg_set_view_location('entities/entity_list', "$plugin_dir/views/override/");
			include("$pages_dir/search.php");
			break;
			// list a developer's plugins
		case "developer":
			set_input('username', $page[1]);
			if (isset($page[2])) {
				set_input($page[2], $page[3]);
			}
			include("$pages_dir/developer.php");
			break;
		case "download":
			// download/<release_guid>/
			set_input('release_guid', $page[1]);
			include("$pages_dir/download.php");
			break;
		// view plugin project
		case "project":
			$project = get_entity($page[1]);
			if ($project) {
				system_message('Please update your bookmark or report this link to the site owner as this page has moved.');
				header("Location: {$project->getURL()}", true, 301);
				exit;
			}
			break;
		// view specfic release of a project
		case "release":
			$release = get_entity($page[1]);
			if ($release) {
				system_message('Please update your bookmark or report this link to the site owner as this page has moved.');
				header("Location: {$release->getURL()}", true, 301);
				exit;
			}
			break;
		// create new plugin project or release
		case "new":
			if ($page[1] == 'release') {
				// new/release/<project guid>/
				set_input('project_guid', $page[2]);
				include("$pages_dir/create_release.php");
			} else {
				// new/project/<username>/
				set_input('username', $page[2]);
				include("$pages_dir/create_project.php");
			}
			break;
		// edit plugin project or release
		case 'edit':
			if ($page[1] == 'release') {
				// edit/release/<release guid>/
				set_input('release_guid', $page[2]);
				include("$pages_dir/edit_release.php");
			} else {
				// edit/project/<project guid>/
				set_input('project_guid', $page[2]);
				include("$pages_dir/edit_project.php");
			}
			break;
		// admin page
		case "admin":
			set_input('tab', $page[1]);
			include("$pages_dir/admin.php");
			break;
		case "transfer":
			admin_gatekeeper();
			set_input('guid', $page[1]);
			include("$pages_dir/transfer.php");
		case "contributors":
			set_input('guid', $page[1]);
			include("$pages_dir/contributors.php");
			break;
		default:
			if (!isset($page[0])) {
				// /plugins is the main page
				include "$pages_dir/index.php";
				break;
			} elseif ($page[1] == 'read') {
				// for backwards compatibility this handles /plugins/<username>/read/<guid>/<title>
				$project = get_entity($page[2]);
				if ($project) {
					system_message('Please update your bookmark or report this link to the site owner as this page has moved.');
					header("Location: {$project->getURL()}", true, 301);
					exit;
				}
				break;
			} 
			
			set_input('guid', $page[0]);
			set_input('version', $page[1]);					
			
			include "$pages_dir/view.php";
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
	header("Content-type: {$file->getMimeType()}");
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
 * @param PluginProject $project
 * @return string
 */
function plugins_project_url_handler($project) {
	$release = $project->getRecommendedRelease();
	if ($release) {
		return $release->getURL();
	}
}

/**
 * Populates the ->getUrl() method for plugin releases
 * Redirects to the project page.
 *
 * @param PluginRelease $release 
 * @return string
 */
function plugins_release_url_handler($release) {
	if (!$release) {
		error_log("Community plugins: unable to access release to get URL");
		return;
	}
	$project = $release->getProject();
	if (!$project) {
		error_log("Community plugins: unable to access project for release $release->guid");
		return;
	}
	$version = rawurlencode($release->version);
	$title = elgg_get_friendly_title($project->title);
	return  "plugins/$project->guid/$version/$title";
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
 * Nightly update on download counts
 *
 * Adds 1.2M to the figure to account for downloads before this system as implemented.
 */
function plugins_update_download_counts() {
	$count = count_annotations(0, 'object', 'plugin_project', 'download', '', NULL);
	$count += 1200000;
	elgg_set_plugin_setting('site_plugins_downloads', $count, 'community_plugins');
}
