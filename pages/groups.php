<?php
/**
 * List all groups
 */

// all groups doesn't get link to self
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('groups'));

elgg_register_title_button();

$selected_tab = get_input('filter', 'featured');

switch ($selected_tab) {
	case 'popular':
		$content = elgg_list_entities_from_relationship_count(array(
			'type' => 'group',
			'relationship' => 'member',
			'inverse_relationship' => false,
			'full_view' => false,
		));
		break;
	case "language":
		$content = elgg_list_entities_from_metadata(array(
			'type' => 'group',
			'metadata_name' => 'group_category',
			'metadata_value' => 'language',
			'limit' => $limit,
			'full_view' => false,
		));
		break;
	case "plugins":
		$content = elgg_list_entities_from_metadata(array(
			'type' => 'group',
			'metadata_name' => 'group_category',
			'metadata_value' => 'plugins',
			'limit' => $limit,
			'full_view' => false,
		));
		break;
	case "developers":
		$content = elgg_list_entities_from_metadata(array(
			'type' => 'group',
			'metadata_name' => 'group_category',
			'metadata_value' => 'developers',
			'limit' => $limit,
			'full_view' => false,
		));
		break;
	case "support":
		$content = elgg_list_entities_from_metadata(array(
			'type' => 'group',
			'metadata_name' => 'group_category',
			'metadata_value' => 'support',
			'limit' => $limit,
			'full_view' => false,
		));
		break;
	case 'featured':
	default:
		$content = elgg_list_entities_from_metadata(array(
			'type' => 'group',
			'metadata_name' => 'featured_group',
			'metadata_value' => 'yes',
			'limit' => $limit,
			'full_view' => false,
		));
		break;
}

if (!$content) {
	$content = elgg_echo('groups:none');
}

$filter = elgg_view('groups/group_sort_menu', array('selected' => $selected_tab));

$sidebar = elgg_view('groups/sidebar/find');
$sidebar .= elgg_view('groups/sidebar/featured');

$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'filter' => $filter,
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page(elgg_echo('groups:all'), $body);
