<?php
/**
 * Edit plugin release
 */

gatekeeper();

$project = get_entity(get_input('plugin'));
$release = get_entity(get_input('release'));

if (!$release || !$release->canEdit()) {
	register_error(elgg_echo('plugins:action:invalid_access'));
	forward();
}

elgg_set_page_owner_guid($project->owner_guid);

elgg_push_breadcrumb(elgg_echo('plugins'), 'plugins');
elgg_push_breadcrumb($project->title, $project->getURL());
elgg_push_breadcrumb($release->version, $release->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

$sidebar = elgg_view('plugins/project_sidebar', array('entity' => $project));

$title = elgg_echo('plugins:edit:release');

$content = elgg_view_form("plugins/save_release", array(
	'enctype' => 'multipart/form-data',
), array(
	'release' => $release,
));

$body = elgg_view_layout('one_sidebar', array(
    'title' => $title,
	'sidebar' => $sidebar, 
	'content' => $content,
));
echo elgg_view_page($title, $body);
