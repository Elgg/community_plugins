<?php
/**
 * Blog integration settings tab
 */

$token = elgg_get_plugin_setting('blog_token', 'community_groups');
if (!$token) {
	$token = generate_action_token(time());
	elgg_set_plugin_setting('blog_token', $token, 'community_groups');
}

$url = elgg_get_site_url();
$url .= "services/api/rest/json/?method=blog.post&token=$token";


echo '<p class="mtm">' . elgg_echo('cg:admin:blog:instruct') . '</p>';

echo '<div><label>' . elgg_echo('cg:admin:blogurl') . ':</label> ';
echo elgg_view('input/text', array('value' => $url));
echo '</div>';

// create list of groups for the form
$options = array('type' => 'group', 'limit' => 0);
$groups = elgg_get_entities($options);
$options = array();
foreach ($groups as $group) {
	if ($group->guid != $vars['post']->container_guid) {
		$options[$group->guid] = $group->name;
	}
}
asort($options);

// get previous group guid that was set
$group_guid = elgg_get_plugin_setting('blog_group_guid', 'community_groups');


$form_body .= '<div>';
$form_body .= '<label>';
$form_body .= elgg_echo('cg:admin:bloggroup');
$form_body .= ':</label> ';
$form_body .= elgg_view('input/dropdown', array(
	'name' => 'group_guid',
	'options_values' => $options,
	'value' => $group_guid,
));
$form_body .= '</div>';

$form_body .= '<div>';
$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));
$form_body .= '</div>';

echo elgg_view('input/form', array(
	'action' => 'action/groups/saveblogsettings',
	'body' => $form_body,
	'class' => 'mtm',
));
