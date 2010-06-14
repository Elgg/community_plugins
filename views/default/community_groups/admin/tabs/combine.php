<?php

$options = array('type' => 'group', 'limit' => 0);
$groups = elgg_get_entities($options);
$options = array();
foreach ($groups as $group) {
	$options[$group->guid] = $group->name;
}

asort($options);

$form_body .= '<p>';
$form_body .= '<label>';
$form_body .= elgg_echo('cg:admin:combine:from');
$form_body .= ':</label> ';
$form_body .= elgg_view('input/pulldown', array('internalname' => 'group_guid_from',
												'options_values' => $options));
$form_body .= '</p>';

$form_body .= '<p>';
$form_body .= '<label>';
$form_body .= elgg_echo('cg:admin:combine:to');
$form_body .= ':</label> ';
$form_body .= elgg_view('input/pulldown', array('internalname' => 'group_guid_to',
												'options_values' => $options));
$form_body .= '</p>';

$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));

echo '<p>' . elgg_echo('cg:admin:combine:instruct') . '</p>';

echo elgg_view('input/form', array('action' => $CONFIG->url . 'action/groups/combine',
									'body' => $form_body,
								));

