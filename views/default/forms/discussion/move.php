<?php
/**
 * Discussion topic move form
 *
 * @uses $vars['entity']
 */

$options = array('type' => 'group', 'limit' => 0);
$groups = elgg_get_entities($options);
$options = array();
foreach ($groups as $group) {
	if ($group->guid != $vars['entity']->container_guid) {
		$options[$group->guid] = $group->name;
	}
}

asort($options);

echo '<div>';
echo '<label>';
echo elgg_echo('cg:forum:move:instruct');
echo ':</label> ';
echo elgg_view('input/dropdown', array(
	'name' => 'group_guid',
	'options_values' => $options,
));
echo elgg_view('input/hidden', array(
	'name' => 'post_guid',
	'value' => $vars['entity']->guid,
));
echo '</div>';

echo '<div class="elgg-foot">';
echo elgg_view('input/submit', array('value' => elgg_echo('submit')));
echo '</div>';
