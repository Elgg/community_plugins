<?php
/**
 * Discussion controls for moderators
 */

$params = array('class' => 'elgg-menu-hz mvm');
if (isset($vars['entity'])) {
	$params['entity'] = $vars['entity'];
}
if (isset($vars['annotation'])) {
	$params['annotation'] = $vars['annotation'];
}

echo elgg_view_menu('cg:moderator', $params);
