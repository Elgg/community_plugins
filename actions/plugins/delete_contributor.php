<?php

$project_guid = get_input('project');
$user_guid = get_input('user');

$project = get_entity($project_guid);
$user = get_user($user_guid);

if (!$project || !$project->canEdit() || !elgg_instanceof($project, 'object', 'plugin_project')) {
  register_error(elgg_echo('plugins:action:invalid_project'));
  forward(REFERER);
}

if (!$user) {
  register_error(elgg_echo('plugins:action:invalid_user'));
  forward(REFERER);
}

remove_entity_relationship($user->guid, PLUGINS_CONTRIBUTOR_RELATIONSHIP, $project->guid);

system_message(elgg_echo('plugins:action:delete_contributor:success'));
forward($project->getURL());