<?php
/**
 * Edit plugin release
 */

gatekeeper();

$release_guid = (int) get_input('release_guid');
$release = get_entity($release_guid);
if (!$release || !$release->canEdit()) {
	register_error('Unknown project or insufficient access.');
	forward();
}

$project = get_entity($release->container_guid);

elgg_set_page_owner_guid($project->owner_guid);

$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:edit:release');

$content = elgg_view_title($title);
$form_vars = array('enctype' => 'multipart/form-data');
$body_vars = plugins_perform_form_vars(null,$release);
$content .= elgg_view_form("plugins/save_release", $form_vars, $body_vars);

$body = elgg_view_layout('one_sidebar', array(
	'sidebar' => $sidebar, 
	'content' => $content,
));
echo elgg_view_page($title, $body);
