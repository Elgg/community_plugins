<?php
/**
 * Group categorization tab
 */

$offset = get_input('offset', 0);
$limit = 10;

$options = array('type' => 'group', 'limit' => 0, 'count' => true);
$num_groups = elgg_get_entities($options);

$options = array('type' => 'group', 'limit' => $limit, 'offset' => $offset);
$groups = elgg_get_entities($options);

$categories = community_groups_get_categories();
$categories[] = '';
sort($categories);


$pagination = elgg_view('navigation/pagination', array(
	'limit' => $limit,
	'offset' => $offset,
	'count' => $num_groups,
));

echo $pagination;

$form_body = '<table class="elgg-table mbm">';
foreach ($groups as $group) {
	$class = $class ? '' : 'class="alt"';
	$params = array(
		'name' => "category[$group->guid]",
		'value' => $group->group_category,
		'options' => $categories,
	);
	$dropdown = elgg_view('input/dropdown', $params);
	$form_body .= "<tr $class><td>$group->name</td><td>$dropdown</td></tr>";
}
$form_body .= '</table>';

$form_body .= elgg_view('input/hidden', array(
	'name' => 'offset',
	'value' => $offset + $limit,
));

$form_body .= '<div>';
$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));
$form_body .= '</div>';

echo elgg_view('input/form', array(
	'action' => 'action/groups/categorize',
	'body' => $form_body,
));
