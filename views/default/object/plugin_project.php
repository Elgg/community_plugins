<?php
/**
 * Elgg plugin project object view.
 *
 * Four views:
 * full
 * search listing
 * front page listing (plugin_project context)
 * widget listing
 */

switch (elgg_get_context()) {
	case 'search':
		echo elgg_view('object/plugin_project/search', $vars);
		break;
	case 'plugin_project':
		echo elgg_view('object/plugin_project/plugin_project', $vars);
		break;
	case 'widgets':
		echo elgg_view('object/plugin_project/widget', $vars);
		break;
	case 'plugins':
	default:
		echo elgg_view('object/plugin_project/plugins', $vars);
		break;
}
