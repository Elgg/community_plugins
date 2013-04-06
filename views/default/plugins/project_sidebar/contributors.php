<?php

$project = $vars['entity'];

$contributors = elgg_get_entities_from_relationship(array(
	'type' => 'user',
	'relationship' => PLUGINS_CONTRIBUTOR_RELATIONSHIP,
	'relationship_guid' => $project->guid,
	'inverse_relationship' => TRUE,
	'limit' => false,
	'order_by' => 'r.time_created ASC'
));

foreach ($contributors as $contributor) {
  $icon = elgg_view_entity_icon($contributor, 'tiny');
  $link = elgg_view('output/url', array(
	 'text' => $contributor->name,
	  'href' => $contributor->getURL(),
	  'is_trusted' => TRUE
  ));
  
  $delete = '';
  if ($project->canEdit()) {
	$href = "action/plugins/delete_contributor?project={$project->guid}&user={$contributor->guid}";
	$delete = elgg_view('output/confirmlink', array(
		'text' => '<span class="elgg-icon elgg-icon-delete"></span>',
		'href' => $href,
		'is_action' => TRUE
	));
  }
  
  echo elgg_view_image_block($icon, $link, array('image_alt' => $delete));
}