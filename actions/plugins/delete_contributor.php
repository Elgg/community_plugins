<?php

$project_guid = get_input('project');
$user_guid = get_input('user');

$project = get_entity($project_guid);
$user = get_user($user_guid);

if (!$project || !$project->canEdit() || !elgg_instanceof($project, 'object', 'plugin_project')) {
  register_error('Invalid Project');
  forward(REFERER);
}

if (!$user) {
  register_error('Invalid User');
  forward(REFERER);
}

remove_entity_relationship($user->guid, PLUGINS_CONTRIBUTOR_RELATIONSHIP, $project->guid);

system_message('User has been removed from the contributors list');
forward($project->getURL());