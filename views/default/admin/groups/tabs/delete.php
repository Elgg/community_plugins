<?php
/**
 * delete group tab
 */

$options = array('type' => 'group', 'limit' => 0);
$groups = elgg_get_entities($options);
$options = array();
foreach ($groups as $group) {
	$options[$group->guid] = $group->name;
}

asort($options);

$form_body = '<div><label>';
$form_body .= elgg_echo('cg:admin:delete:instruct');
$form_body .= ':</label> ';
$form_body .= elgg_view('input/dropdown', array(
	'name' => 'group_guid',
	'options_values' => $options,
));
$form_body .= '</div><div>';
$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));
$form_body .= '</div>';

echo elgg_view('input/form', array(
	'action' => 'action/groups/delete',
	'body' => $form_body,
));
