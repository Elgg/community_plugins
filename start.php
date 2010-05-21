<?php
/**
 * Elgg community plugin repository
 * 
 */

require_once(dirname(__FILE__) . '/lib/plugin_functions.php');

// Register a class
function plugins_run_once(){
	add_subtype("object", "plugin_file", "FilePluginFile");
}

/**
 * plugin initialisation
 */
function plugins_init() {
	global $CONFIG;

	run_function_once('plugins_run_once');

	// Set up menu for logged in users
	if (isloggedin()) {
		add_menu(elgg_echo('plugins'), $CONFIG->wwwroot . "pg/plugins/all/");
	}

	// Extend CSS
	extend_view('css', 'plugins/css');

	// Extend hover-over and profile menu
	extend_view('profile/menu/links','plugins/menu');
	extend_view('groups/left_column','plugins/groupprofile_files');

	// Register a page handler, so we can have nice URLs
	register_page_handler('plugins','plugins_page_handler');

	// Image handler
	register_page_handler('plugins_image', 'plugins_image_page_handler');

	if (is_callable('register_notification_object'))
		register_notification_object('object', 'plugins', elgg_echo('plugins:new'));

	//register a widget
	add_widget_type('plugins',elgg_echo('plugins'), elgg_echo('plugins'), 'profile');

	// Register a URL handler for files to redirect to project
	register_entity_url_handler('plugins_file_url_handler', 'object', 'plugin_file');

	// register url handler for projects
	register_entity_url_handler('plugins_project_url_handler', 'object', 'plugin_project');

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
		'artistic' => 'Artistic License 2.0',
		'artistic' => 'Clarified Artistic License',
		'berkeleydb' => 'Berkeley Database License (aka the Sleepycat Software Product License)',
		'boost' => 'Boost Software License',
		'mbsd' => 'Modified BSD license',
		'cbsd' => 'The Clear BSD License',
		'cecill' => 'CeCILL version 2',
		'cryptix' => 'Cryptix General License',
		'ecos' => 'eCos license version 2.0',
		//'edu' => 'Educational Community License 2.0',
		'eiffel' => 'Eiffel Forum License, version 2',
		'eudatagrid' => 'EU DataGrid Software License',
		'expat' => 'Expat (MIT) License',
		'freebsd' => 'FreeBSD license',
		//'freetype' => 'Freetype Project License',
		//'jpeg' => 'Independent JPEG Group License',
		'intel' => 'Intel Open Source License',
		'openbsd' => 'ISC (OpenBSD) License',
		'ncsa' => 'NCSA/University of Illinois Open Source License',
		//'public' => 'Public Domain',
		'sgi' => 'SGI Free Software License B, version 2.0',
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

	// Only projects should show up in search
	//register_entity_type('object','plugins');
	register_entity_type('object', 'plugin_project');

	// Special hook for searching against metadata (category
	register_plugin_hook('search', 'object:plugin_project', 'plugins_search_hook');
}

/**
 * Sets up submenus for the file system.  Triggered on pagesetup.
 *
 */
function plugins_submenus() {
	global $CONFIG;

	$page_owner = page_owner_entity();

	// General submenu options
	if (get_context() == "plugins") {
		if ((page_owner() == $_SESSION['guid'] || !page_owner()) && isloggedin()) {
			add_submenu_item(sprintf(elgg_echo("plugins:yours"),elgg_echo('plugins:types:')), $CONFIG->wwwroot . "pg/plugins/developer/" . page_owner_entity()->username);
			//add_submenu_item(sprintf(elgg_echo('plugins:yours:friends'),page_owner_entity()->name), $CONFIG->wwwroot . "pg/plugins/". page_owner_entity()->username . "/friends/");
		} else if (page_owner()) {
			add_submenu_item(sprintf(elgg_echo("plugins:user"),$page_owner->name,elgg_echo('plugins:types:')), $CONFIG->wwwroot . "pg/plugins/developer/" . $page_owner->username);
			//if ($page_owner instanceof ElggUser) // This one's for users, not groups
				//add_submenu_item(sprintf(elgg_echo('plugins:friends'),$page_owner->name), $CONFIG->wwwroot . "pg/plugins/". $page_owner->username . "/friends/");
		}
		add_submenu_item(elgg_echo('plugins:all'), $CONFIG->wwwroot . "pg/plugins/all/");
		if (can_write_to_container($_SESSION['guid'], page_owner()))
			add_submenu_item(elgg_echo('plugins:upload'), $CONFIG->wwwroot . "pg/plugins/new/". page_owner_entity()->username);
	}
}

/**
 * File page handler
 *
 * @param array $page Array of page elements, forwarded by the page handling mechanism
 */
function plugins_page_handler($page) {

	global $CONFIG;

	$plugin_dir = $CONFIG->pluginspath . "community_plugins";

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
			include("$plugin_dir/search.php");
			break;
		// list a developer's plugins
		case "developer":
			set_input('username', $page[1]);
			if (isset($page[2])) {
				set_input($page[2], $page[3]);
			}
			include("$plugin_dir/index.php");
			break;
		// plugin project
		case "project":
			set_input('guid', $page[1]);
			include("$plugin_dir/read.php");
			break;
		// specfic release of a project
		case "release":
			set_input('release', $page[1]);
			include("$plugin_dir/read.php");
			break;
		// create new plugin project
		case "new":
			set_input('username', $page[1]);
			include("$plugin_dir/create_project.php");
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
 * @param $entity
 * @return unknown_type
 */
function plugins_project_url_handler($entity) {
	global $CONFIG;

	$title = $entity->title;
	$title = friendly_title($title);
	return $CONFIG->url . "pg/plugins/project/{$entity->getGUID()}/developer/{$entity->getOwnerEntity()->username}/$title";
}

/**
 * Populates the ->getUrl() method for plugin files
 * Redirects to the project page.
 *
 * @param ElggEntity $entity File entity
 * @return string File URL
 */
function plugins_file_url_handler($entity) {
	global $CONFIG;

	$title = $entity->title;
	$title = friendly_title($title);
	return $CONFIG->url . "pg/plugins/release/$entity->guid/developer/{$entity->getOwnerEntity()->username}/$title";
}

/**
 * Returns an overall file type from the mimetype
 *
 * @param string $mimetype The MIME type
 * @return string The overall type
 */
function plugins_get_general_file_type($mimetype) {

	switch($mimetype) {
		case "application/msword":
			return "document";
			break;
		case "application/pdf":
			return "document";
			break;
	}

	if (substr_count($mimetype,'text/'))
		return "document";

	if (substr_count($mimetype,'audio/'))
		return "audio";

	if (substr_count($mimetype,'image/'))
		return "image";

	if (substr_count($mimetype,'video/'))
		return "video";

	if (substr_count($mimetype,'opendocument'))
		return "document";

	return "general";

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

	$plugin_types = get_tags(0, 10, 'plugin_type', 'object', 'plugin_project');

	foreach ($plugin_types as $type) {

		$tag = $type->tag;
		$label = elgg_echo("plugins:type:" . $tag);

		$url = "{$CONFIG->url}pg/plugins/developer/$owner->username/type/$tag/";

		add_submenu_item($label, $url, 'pluginstypes');
	}
}

/* This is a function to make urls clickable on the wire
 * We also look for internal links generated by 'Discuss on the wire' - these have the form !L:1htyr!
 * and will always be at the beginning on the message, users can't change this
 * parse_urls($text, $maxurl_len = 60, $target = '_self')
 * We don't sanitise the text variable as that comes from the db so will have been sanitised already
 **/
       
function plugin_urls($text, $maxurl_len = 60, $target = '_blank') {
	//find out if the wire post contains an internal url, if so get it and display
	$internal_url = substr($text,0,11);
	//check that in internal link code exists
	$first_position = strpos($internal_url,"{{", 0);
	$second_position = strpos($internal_url,"}}",9);
	if($first_position == 0 && $second_position == 9){
		//get the actual web address
		$get_url = get_entities_from_metadata("link_version", $internal_url, "object", "bookmarks", 0, 1);
		foreach($get_url as $gu){
			$address = $gu->address;
			break;
		}
		//replace the short internal code with the url, which will be replace by view link below
		$text = str_replace($internal_url, $address, $text);
	}
	
	$target = sanitise_string($target);
	$maxurl_len = (int)$maxurl_len;
	//$text = sanitise_string($text);
	if (preg_match_all('/(?<!href=["\'])((ht|f)tps?:\/\/[^\s\r\n\t<>"\'\!\(\)]+)/ie', $text, $urls))   {
    	foreach (array_unique($urls[1]) AS $url){
        	$urltext = $url;
            $text = str_replace($url, '<a href="'. $url .'" class="view_link" target="'.$target.'">view link</a>', $text);
      	}
 	}
    return $text;
} 


// Make sure test_init is called on initialisation
register_elgg_event_handler('init','system','plugins_init');
register_elgg_event_handler('pagesetup','system','plugins_submenus');

// Register actions
register_action("plugins/create_project", false, $CONFIG->pluginspath . "community_plugins/actions/create_project.php");
register_action("plugins/create_release", false, $CONFIG->pluginspath . "community_plugins/actions/create_release.php");
register_action("plugins/save_project", false, $CONFIG->pluginspath . "community_plugins/actions/save_project.php");
register_action("plugins/save_release", false, $CONFIG->pluginspath . "community_plugins/actions/save_release.php");
register_action("plugins/delete_project", false, $CONFIG->pluginspath. "community_plugins/actions/delete_project.php");
register_action("plugins/delete_release", false, $CONFIG->pluginspath. "community_plugins/actions/delete_release.php");
register_action("plugins/delete_project_image", false, $CONFIG->pluginspath. "community_plugins/actions/delete_project_image.php");
register_action("plugins/digg", false, $CONFIG->pluginspath . "community_plugins/actions/digg.php");
