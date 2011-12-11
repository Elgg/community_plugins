<?php
/**
 * Combine groups tab
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
$form_body .= elgg_echo('cg:admin:combine:from');
$form_body .= ':</label> ';
$form_body .= elgg_view('input/dropdown', array(
	'name' => 'group_guid_from',
	'options_values' => $options,
));
$form_body .= '</div>';

$form_body .= '<div>';
$form_body .= '<label>';
$form_body .= elgg_echo('cg:admin:combine:to');
$form_body .= ':</label> ';
$form_body .= elgg_view('input/dropdown', array(
	'name' => 'group_guid_to',
	'options_values' => $options,
));
$form_body .= '</div>';

$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));

echo '<p>' . elgg_echo('cg:admin:combine:instruct') . '</p>';

echo elgg_view('input/form', array(
	'action' => 'action/groups/combine',
	'body' => $form_body,
));

