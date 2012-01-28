<?php
/**
 * Combining plugin projects
 */
?>
<h3>Combine plugin projects</h3>
<?php
$form_body = '<p>';
$form_body .= elgg_view('input/text',
		array(
			'internalname' => 'old_guid',
			'class' => 'none',
		));
$form_body .= ' GUID of plugin project that is be replaced in the combination';
$form_body .= '</p><p>';

$form_body .= elgg_view('input/text',
		array(
			'internalname' => 'new_guid',
			'class' => 'none',
		));
$form_body .= ' GUID of plugin project that remains in the combination';
$form_body .= '</p>';

$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));

$action = elgg_get_site_url() . "action/plugins/combine/";

echo elgg_view('input/form', array('body' => $form_body, 'action' => $action));
