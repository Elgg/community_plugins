<?php
/**
 * Change owner tab
 */

$options = array('type' => 'group', 'limit' => 0);
$groups = elgg_get_entities($options);
$options = array();
foreach ($groups as $group) {
	$options[$group->guid] = $group->name;
}

asort($options);


$form_body .= '<div>';
$form_body .= '<label>';
$form_body .= elgg_echo('group');
$form_body .= ':</label> ';
$form_body .= elgg_view('input/dropdown', array(
	'name' => 'group_guid',
	'options_values' => $options,
));
$form_body .= '</div>';

$form_body .= '<div>';
$form_body .= '<label>';
$form_body .= elgg_echo('cg:admin:change_owner:user');
$form_body .= ':</label> ';
$form_body .= elgg_view('input/userpicker', array('name' => 'user_guid_array'));
$form_body .= '</div>';

$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));

echo '<p>' . elgg_echo('cg:admin:change_owner:instruct') . '</p>';

echo elgg_view('input/form', array(
	'action' => 'action/groups/change_owner',
	'body' => $form_body,
));
