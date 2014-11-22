<?php

namespace Community\Plugins;
use Elgg\CommunityPlugins\UriTemplate;

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
			forward("/plugins/{$plugin->guid}/releases/{$release->guid}/edit");
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
			
			include dirname(__DIR__) . '/pages/plugins/list.php';
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
	$plugin_dir = dirname(dirname(__FILE__));
	$pages_dir = "$plugin_dir/pages";
	
	foreach($urls as $state => $template_str) {
		$template = new UriTemplate($template_str);

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
		$template = new UriTemplate($template_str);
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
