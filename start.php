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
 * File plugin initialisation functions.
 */
function plugins_init() {
	// Get config
	global $CONFIG;

	run_function_once('plugins_run_once');

	// Set up menu for logged in users
	if (isloggedin()) {
		add_menu(elgg_echo('plugins'), $CONFIG->wwwroot . "pg/plugins/all/all/");
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

	// Group submenu option
	if ($page_owner instanceof ElggGroup && get_context() == 'groups') {
		if($page_owner->files_enable == "yes"){
			add_submenu_item(sprintf(elgg_echo("plugins:group"),$page_owner->name), $CONFIG->wwwroot . "pg/plugins/" . $page_owner->username);
		}
	}

	// General submenu options
	if (get_context() == "plugins") {
		if ((page_owner() == $_SESSION['guid'] || !page_owner()) && isloggedin()) {
			add_submenu_item(sprintf(elgg_echo("plugins:yours"),page_owner_entity()->name), $CONFIG->wwwroot . "pg/plugins/" . page_owner_entity()->username);
			//add_submenu_item(sprintf(elgg_echo('plugins:yours:friends'),page_owner_entity()->name), $CONFIG->wwwroot . "pg/plugins/". page_owner_entity()->username . "/friends/");
		} else if (page_owner()) {
			add_submenu_item(sprintf(elgg_echo("plugins:user"),$page_owner->name), $CONFIG->wwwroot . "pg/plugins/" . $page_owner->username);
			//if ($page_owner instanceof ElggUser) // This one's for users, not groups
				//add_submenu_item(sprintf(elgg_echo('plugins:friends'),$page_owner->name), $CONFIG->wwwroot . "pg/plugins/". $page_owner->username . "/friends/");
		}
		add_submenu_item(elgg_echo('plugins:all'), $CONFIG->wwwroot . "pg/plugins/all/all/");
		if (can_write_to_container($_SESSION['guid'], page_owner()))
			add_submenu_item(elgg_echo('plugins:upload'), $CONFIG->wwwroot . "pg/plugins/". page_owner_entity()->username . "/new/");
	}
}

/**
 * File page handler
 *
 * @param array $page Array of page elements, forwarded by the page handling mechanism
 */
function plugins_page_handler($page) {

	global $CONFIG;

	// The username should be the file we're getting
	if (isset($page[0])) {
		set_input('username',$page[0]);
	}

	if (isset($page[1])) {
		switch($page[1]) {
			case "read":
				set_input('guid',$page[2]);
				include($CONFIG->pluginspath . "community_plugins/read.php");
			break;
			case "all":
				include($CONFIG->pluginspath . "community_plugins/all.php");
			break;
			case "new":
				include($CONFIG->pluginspath . "community_plugins/upload.php");
			break;
		}
	} else {
		// Include the standard profile index
		include($CONFIG->pluginspath . "community_plugins/index.php");
	}
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
	return $CONFIG->url . "pg/plugins/" . $entity->getOwnerEntity()->username . "/read/" . $entity->getGUID(). "/" . $title;
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
	return $CONFIG->url . "pg/plugins/" . $entity->getOwnerEntity()->username . "/read/" . $entity->container_guid. "/" . $title;
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
 * Returns a list of filetypes to search specifically on
 *
 * @param int|array $owner_guid The GUID(s) of the owner(s) of the files
 * @param true|false $friends Whether we're looking at the owner or the owner's friends
 * @return string The typecloud
 */
function plugins_get_filetype_cloud($owner_guid = "", $friends = false) {

	if ($friends) {
		if ($friendslist = get_user_friends($user_guid, $subtype, 999999, 0)) {
			$friendguids = array();
			foreach($friendslist as $friend) {
				$friendguids[] = $friend->getGUID();
			}
		}
		$friendofguid = $owner_guid;
		$owner_guid = $friendguids;
	} else {
		$friendofguid = false;
	}
	return elgg_view('plugins/typecloud',array('owner_guid' => $owner_guid, 'friend_guid' => $friendofguid, 'types' => get_tags(0,10,'plugin_type','object','plugins',$owner_guid)));

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
global $CONFIG;
register_action("plugins/upload", false, $CONFIG->pluginspath . "community_plugins/actions/upload.php");
register_action("plugins/digg", false, $CONFIG->pluginspath . "community_plugins/actions/digg.php");
register_action("plugins/update", false, $CONFIG->pluginspath . "community_plugins/actions/update.php");
register_action("plugins/save_project", false, $CONFIG->pluginspath . "community_plugins/actions/save_project.php");
register_action("plugins/save_release", false, $CONFIG->pluginspath . "community_plugins/actions/save_release.php");
register_action("plugins/delete_project", false, $CONFIG->pluginspath. "community_plugins/actions/delete_project.php");
register_action("plugins/delete_release", false, $CONFIG->pluginspath. "community_plugins/actions/delete_release.php");
register_action("plugins/delete_project_image", false, $CONFIG->pluginspath. "community_plugins/actions/delete_project_image.php");
