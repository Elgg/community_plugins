<?php
/**
 * Combining plugin projects
 */
?>
<h3>Transfer a plugin project</h3>
<?php
$form_body = '<p>';
$form_body .= elgg_view('input/text',
		array(
			'internalname' => 'project_guid',
			'class' => 'none',
		));
$form_body .= ' GUID of plugin project';
$form_body .= '</p><p>';

$form_body .= elgg_view('input/autocomplete',
		array(
			'internalname' => 'user_guid',
			'class' => 'none',
			'match_on' => array('users')
		));
$form_body .= ' New owner.';
$form_body .= '</p>';

$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));

$action = "{$vars['url']}action/plugins/transfer/";

echo elgg_view('input/form', array('body' => $form_body, 'action' => $action));
