<?php

$user_guid = elgg_get_logged_in_user_guid();
$project_guid = get_input('project_guid');
$description = get_input('description');

$project = get_entity($project_guid);

if (!$project instanceof PluginProject) {
	register_error(elgg_echo('plugins:error:not_found'));
	forward(REFERER);
}

if (empty($description)) {
	register_error(elgg_echo('plugins:error:invalid_ownership_request'));
	forward(REFERER);
}

$exists = elgg_annotation_exists($project_guid, 'ownership_request', $user_guid);

if ($exists) {
	register_error(elgg_echo('plugins:error:ownership_request_exists'));
	forward(REFERER);
}

$success = $project->annotate('ownership_request', $description, ACCESS_PUBLIC, $user_guid, 'text');

if (!$success) {
	register_error(elgg_echo('plugins:error:ownership_request_failed'));
	forward(REFERER);
}

// Get all admins and select two of them randomly
$admins = elgg_get_admins();
shuffle($admins);
$admins = array_slice($admins, 0, 2);

// Notify the admins about the new request
foreach ($admins as $admin) {
	$url = elgg_get_site_url() . "plugins/{$project->guid}/ownership_requests";

	$subject = elgg_echo('plugins:ownership_request:notify:subject', array(), $admin->language);
	$message = elgg_echo('plugins:ownership_request:notify:body', array($url), $admin->language);

	notify_user($admin->guid, 0, $subject, $message, array(), 'email');
}

system_message(elgg_echo('plugins:ownership_request:success'));

forward($project->getURL());
