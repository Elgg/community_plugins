<?php

$guid = get_input('project_guid');
$project = get_entity($guid);
$members = get_input('members');

if (!$project || !$project->canEdit() || !elgg_instanceof($project, 'object', 'plugin_project')) {
  register_error('Invalid Project');
  forward(REFERER);
}

if (!$members || !is_array($members)) {
  register_error('Invalid Contributors');
  forward(REFERER);
}

// add members as contributors
foreach ($members as $guid) {
  $member = get_user($guid);
  
  if ($member) {
	add_entity_relationship($member->guid, PLUGINS_CONTRIBUTOR_RELATIONSHIP, $project->guid);
  }
}


system_message('Contributors have been added.');
forward($project->getURL());