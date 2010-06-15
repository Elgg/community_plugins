<?php

$offset = get_input('offset', 0);
$limit = 10;

$options = array('type' => 'group', 'limit' => 0, 'count' => TRUE);
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

$form_body = '<table id="groupsadmin_category_table">';
foreach ($groups as $group) {
	$class = $class ? '' : 'class="alt"';
	$params = array('internalname' => "category[$group->guid]",
					'value' => $group->group_category,
					'options' => $categories,
					);
	$pulldown = elgg_view('input/pulldown', $params);
	$form_body .= "<tr $class><td>$group->name</td><td>$pulldown</td></tr>";
}
$form_body .= '</table>';

$form_body .= elgg_view('input/hidden', array('internalname' => 'offset', 'value' => $offset + $limit));

$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));

$params = array('body' => $form_body,
				'action' => $CONFIG->url . 'action/groups/categorize');
echo elgg_view('input/form', $params);