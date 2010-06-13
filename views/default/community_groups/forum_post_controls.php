<div class="forum_post_control">
	<h4><?php echo elgg_echo('cg:forum:controls'); ?></h4>
<?php

$options = array('type' => 'group', 'limit' => 0);
$groups = elgg_get_entities($options);
$options = array();
foreach ($groups as $group) {
	if ($group->guid != $vars['post']->container_guid) {
		$options[$group->guid] = $group->name;
	}
}

asort($options);

$form_body = '<label>';
$form_body .= elgg_echo('cg:forum:move:instruct');
$form_body .= ':</label> ';
$form_body .= elgg_view('input/pulldown', array('internalname' => 'group_guid',
												'options_values' => $options));
$form_body .= elgg_view('input/hidden', array('internalname' => 'post_guid',
												'value' => $vars['post']->guid));
$form_body .= '<br />';
$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));

echo elgg_view('input/form', array('action' => $CONFIG->url . 'action/forum/move',
									'body' => $form_body,
								));

?>
</div>