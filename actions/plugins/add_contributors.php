<?php

$guid = get_input('project_guid');
$project = get_entity($guid);
$members = get_input('members');

if (!$project || !$project->canEdit() || !elgg_instanceof($project, 'object', 'plugin_project')) {
  register_error(elgg_echo('plugins:action:invalid_project'));
  forward(REFERER);
}

if (!$members || !is_array($members)) {
  register_error(elgg_echo('plugins:action:invalid_contributors'));
  forward(REFERER);
}

// add members as contributors
foreach ($members as $guid) {
  $member = get_user($guid);
  
  if ($member) {
	add_entity_relationship($member->guid, PLUGINS_CONTRIBUTOR_RELATIONSHIP, $project->guid);
  }
}


system_message(elgg_echo('plugins:action:add_contributors:success'));
forward($project->getURL());