<?php

$guid = get_input('project_guid');
$project = get_entity($guid);
$members = get_input('members');

$recipient = get_user($members[0]);

if (!$project || !$project->canEdit() || !elgg_instanceof($project, 'object', 'plugin_project')) {
  register_error('Invalid Project');
  forward(REFERER);
}

if (!$recipient || $recipient->isBanned() || $recipient->getGUID() == $project->owner_guid) {
  register_error('Invalid Recipient');
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

// change owner for all releases
foreach ($releases as $release) {
  $release->owner_guid = $recipient->getGUID();
  $release->save();
}

// change owner for the whole project
$project->owner_guid = $recipient->getGUID();
$project->container_guid = $recipient->getGUID();
$project->save();

elgg_set_ignore_access($ia);

system_message('Plugin ownership has been transferred.');
forward($project->getURL());
