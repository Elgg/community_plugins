<?php
$url = "{$vars['url']}action/plugins/normalize/";

$guid = $vars['guid'];

$form_body = '<p>';
$form_body .= 'Remove inflated download counts for the currently graphed plugin<br />';
$form_body .= elgg_view('input/hidden', array('internalname' => 'guid', 'value' => $guid));

$form_body .= elgg_view('input/submit', array('value' => elgg_echo('Normalize')));

$form_body .= ' ';  // yes, this should be CSS

$params = array(
	'href' => $url . "?guid=$guid&preview=true",
	'text' => elgg_echo('Preview'),
	'is_action' => TRUE,
	'class' => 'submit_button'
);
$form_body .= elgg_view('output/url', $params);

$form_body .= '</p>';

echo elgg_view('input/form', array('body' => $form_body, 'action' => $url));
