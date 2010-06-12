<?php
/**
 * Has the current user has dugg the plugin project
 * @param $project
 * @return bool
 */
function plugins_is_dugg($project) {
	if (check_entity_relationship(get_loggedin_userid(), "has_dugg", $project->guid)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Plugin project search hook
 * 
 * @param string $hook
 * @param string $type
 * @param <type> $value
 * @param <type> $params
 * @return array
 */
function plugins_search_hook($hook, $type, $value, $params) {
	global $CONFIG;
	$query = sanitise_string($params['query']);

	$join = "JOIN {$CONFIG->dbprefix}objects_entity oe ON e.guid = oe.guid";
	$params['joins'] = array($join);
	$params['joins'][] = "JOIN {$CONFIG->dbprefix}metadata summary_md on e.guid = summary_md.entity_guid";
	$params['joins'][] = "JOIN {$CONFIG->dbprefix}metastrings summary_msn on summary_md.name_id = summary_msn.id";
	$params['joins'][] = "JOIN {$CONFIG->dbprefix}metastrings summary_msv on summary_md.value_id = summary_msv.id";

	$fields = array('title', 'description');
	$where = search_get_where_sql('oe', $fields, $params);

	// cheat and use LIKE for the summary field
	// this is kinda dirty.
	$likes = array();
	$query_arr = explode(' ', $query);
	foreach ($query_arr as $word) {
		$likes[] = "summary_msv.string LIKE \"%$word%\"";
	}
	$like_str = implode(' OR ', $likes);

	//$params['wheres'] = array("($where OR ($like_str))");
	$params['wheres'] = array($where);

//	If metastrings were fulltext'd we could do this :(
//	$select = "summary_msv.string summary_string";
//	$params['selects'] = array($select);
//
//	$fields = array('string');
//	$summary_where = search_get_where_sql('summary_msv', $fields, $params);
//	$params['wheres'][] = $summary_where;

	if (($category = get_input('category')) && ($category != 'all')) {
		$params['metadata_name_value_pair'] = array ('name' => 'plugincat', 'value' => $category, 'case_sensitive' => FALSE);
	}
	$params['order_by'] = search_get_order_by_sql('e', 'oe', $params['sort'], $params['order']);


	$entities = elgg_get_entities_from_metadata($params);
	$params['count'] = TRUE;
	$count = elgg_get_entities_from_metadata($params);

	// no need to continue if nothing here.
	if (!$count) {
		return array('entities' => array(), 'count' => $count);
	}

	// add the volatile data for why these entities have been returned.
	foreach ($entities as $entity) {
		$title = search_get_highlighted_relevant_substrings($entity->title, $params['query']);
		$entity->setVolatileData('search_matched_title', $title);

		$desc = search_get_highlighted_relevant_substrings($entity->summary, $params['query']);
		$entity->setVolatileData('search_matched_description', $desc);
	}

	return array(
		'entities' => $entities,
		'count' => $count,
	);
}
