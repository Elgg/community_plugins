<?php

$guid = get_input('project_guid');
$project = get_entity($guid);
$members = get_input('members');

$recipient = get_user($members[0]);

if (!$project || !$project->canEdit() || !elgg_instanceof($project, 'object', 'plugin_project')) {
	register_error(elgg_echo('plugins:action:invalid_project'));
	forward(REFERER);
}

if (!$recipient || $recipient->isBanned() || $recipient->getGUID() == $project->owner_guid) {
	register_error(elgg_echo('plugins:action:transfer:invalid_recipient'));
	forward(REFERER);
}

//get all releases associated with the project
$releases = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'plugin_release',
	'container_guid' => $project->guid,
	'limit' => 0,
));

$ia = elgg_set_ignore_access(true);

// change owner for the whole project
$project->owner_guid = $recipient->getGUID();
$project->container_guid = $recipient->getGUID();
$project->save();

// Get pending ownership request
$project->deleteAnnotations('ownership_request');

elgg_set_ignore_access($ia);

system_message(elgg_echo('plugins:action:transfer:success'));
forward($project->getURL());
