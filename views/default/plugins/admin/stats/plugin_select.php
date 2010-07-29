<?php
/**
 * Form for selecting a plugin
 */

$form_body = '<p>';
$form_body .= elgg_view('input/text',
		array(
			'internalname' => 'guid',
			'class' => 'none',
		));
$form_body .= ' '; // yes, this should bs CSS

$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));

$form_body .= '</p>';

$url = current_page_url();

echo elgg_view('input/form', array('body' => $form_body, 'action' => $url, 'method' => 'get'));
