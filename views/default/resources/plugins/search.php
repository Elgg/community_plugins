<?php

/**
 * Advanced search page, handling plugin filtering and sorting
 */

global $CONFIG;

// Get search-specific settings
$serialized_settings = elgg_get_plugin_setting('search-settings', 'community_plugins');
$settings = unserialize($serialized_settings);
if (!is_array($settings)) {
	$settings = array();
}

$offset = get_input('offset', 0);
$limit = get_input('limit', 10);

// Filters are passed as an associative, multidimensional array with shortened keys (to fit into IE's max URI length)
$filters = get_input('f');

// Default sort is time_created, descending order
$sort = get_input('sort', 'created');
$direction = get_input('direction', 'desc');

$options = array(
	'type'                      => 'object',
	'subtype'                   => 'plugin_project',
    'offset'                    => $offset,
    'limit'                     => $limit,
    'metadata_name_value_pairs' => array(),
    'metadata_case_sensitive'   => false,
	'joins'                     => array(),
);
$wheres = array();
$group_bys = array();

// Handle entity filtering
if (is_array($filters) && !empty($filters)) {
    foreach ($filters as $key => $value) {
        $key = sanitise_string($key);
        switch ($key) {
            case 't' :
            	if (is_array($settings['text']) && in_array('enabled', $settings['text'])) {
                	// Any text value; will be matched against plugin title, description, summary, tags, author name and username
                	if (strlen($value) > 0) {
	                	$value = sanitise_string($value);
                        // Match title and description
	                	$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (e.guid = o.guid)";
						$fields = array('title', 'description');
						$wheres[] = search_get_where_sql('o', $fields, array('query' => $value, 'joins' => $options['joins']));
						
						//Match author name and username 
                        if  (in_array('author-name', $settings['text']) || in_array('author-username', $settings['text'])) {
							$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}users_entity u ON (e.owner_guid = u.guid)";
							$fields = array();
							if (in_array('author-name', $settings['text'])) {
								$fields[] = 'name';
							}
							if (in_array('author-username', $settings['text'])) {
								$fields[] = 'username';
							}
							$wheres[] = search_get_where_sql('u', $fields, array('query' => $value, 'joins' => $options['joins']));
                        }
						
						// Match summary and tags
                        if  (in_array('summary', $settings['text']) || in_array('tags', $settings['text'])) {
	                        $value_parts = explode(' ', $value);
							$fields = array();
							if (in_array('summary', $settings['text'])) {
								$fields[] = 'summary';
							}
							if (in_array('tags', $settings['text'])) {
								$fields[] = 'tags';
							}
							$fields_str = "'"  . implode("','", $fields) . "'";
	                        $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metadata tm ON (e.guid = tm.entity_guid)";
		                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings tm_name ON (tm.name_id = tm_name.id AND tm_name.string IN ($fields_str))";
		                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings tm_value ON (tm.value_id = tm_value.id)";
		                    foreach ($value_parts as $expression) {
		                    	$wheres[] = "tm_value.string LIKE \"%$expression%\"";
		                    }
                        }
                	}
                }
                break;
	    	// Categories
            case 'c' :
            	if (is_array($settings['category']) && in_array('enabled', $settings['category'])) {
                	if (is_array($value) && !empty($value)) {
                		$categories = '("' . implode('","', $value) . '")';
                		$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metadata cm ON (e.guid = cm.entity_guid)";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings cs_name ON (cm.name_id = cs_name.id AND cs_name.string = 'plugincat')";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings cs_value ON (cm.value_id = cs_value.id AND cs_value.string IN $categories)";
                	}
            	}
                break;
            case 'l' :
            	if (is_array($settings['licence']) && in_array('enabled', $settings['licence'])) {
                	// Licences
                	if (is_array($value) && !empty($value)) {
                		$licences = '("' . implode('","', $value) . '")';
                		$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metadata lm ON (e.guid = lm.entity_guid)";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings ls_name ON (lm.name_id = ls_name.id AND ls_name.string = 'license')";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings ls_value ON (lm.value_id = ls_value.id AND ls_value.string IN $licences)";
                	}
            	}
                break;
            case 'v' :
            	if (is_array($settings['version']) && in_array('enabled', $settings['version'])) {
                	// Elgg versions
                	if (is_array($value) && !empty($value)) {
                		$versions = '("' . implode('","', $value) . '")';
                		$plugin_release_subtype = get_subtype_id('object', 'plugin_release');
                		$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}entities pre ON (e.guid = pre.container_guid AND pre.subtype = $plugin_release_subtype)";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metadata prm ON (pre.guid = prm.entity_guid)";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings prm_name ON (prm.name_id = prm_name.id AND prm_name.string = 'elgg_version')";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings prm_value ON (prm.value_id = prm_value.id AND prm_value.string IN $versions)";
	                    $group_bys[] = 'pre.guid';
                	}
            	}
            	break;
            case 's' :
            	if (isset($settings['screenshot']) && $settings['screenshot'] == 'enabled') {
                	// Only with screenshot
                	$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}entity_relationships r on (r.relationship=\"image\" AND r.guid_one = e.guid)";
            	}
            	break;
        }
    }
}    

// Support for ?owner={username} query parameter
$owner = get_user_by_username(get_input('owner'));
if ($owner) {
	$options['owner_guid'] = $owner->guid;
}

$category = get_input('category');
if (!empty($category)) {
	$options['metadata_name_value_pairs'][] = array(
		'name' => 'plugincat',
		'value' => $category,
	);
}

// WHERE clauses were only added for full text search - so far all WHEREs can be safely joined by 'OR'
if (!empty($wheres)) {
	$options['wheres'] = array();
	$options['wheres'][] = '(' . implode(' OR ', $wheres) . ')';
}

// Handle entity sorting
// Duplicate join clauses will be removed by elgg_get_entities(), so no need to keep track of joins
if ((isset($settings['sort']) && $settings['sort'] == 'enabled') || empty($settings)) {
    switch($sort) {
    	case 'title':
    		$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (e.guid = o.guid)";
    		$options['order_by'] = "o.title {$direction}";
    		break;
    	case 'author':
    		$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}users_entity u ON (e.owner_guid = u.guid)";
    		$options['order_by'] = "u.name {$direction}";
    		break;
    	case 'downloads':
    		$options['selects'] = array("a.downloads");
    		$options['joins'][] = "LEFT JOIN {$CONFIG->dbprefix}plugin_downloads a on (e.guid = a.guid)";
			$group_bys = array_merge(array('e.guid', 'a.guid'), $group_bys);
    		$options['group_by'] = implode(',', $group_bys);
    		$options['order_by'] = "a.downloads {$direction}";
    		break;
    	case 'recommendations':
    		$digg_id = add_metastring('plugin_digg', true);
    		$options['selects'] = array("count(a.entity_guid) as recommendations");
    		$options['joins'][] = "LEFT JOIN {$CONFIG->dbprefix}annotations a on (e.guid = a.entity_guid AND a.name_id = $digg_id)";
			$group_bys = array_merge(array('e.guid', 'a.entity_guid'), $group_bys);
    		$options['group_by'] = implode(',', $group_bys);
    		$options['order_by'] = "recommendations {$direction}";
    		break;
    	case 'created':
    		$options['order_by'] = "e.time_created {$direction}";
    		break;
    	case 'updated':
    		$options['selects'] = array("max(er.time_created) as last_update");
    		$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}entities er ON (er.container_guid = e.guid)";
    		$options['group_by'] = "e.guid";
    		$options['order_by'] = "last_update {$direction}";
    		break;
    }
}

// Get objects
elgg_set_context('search');
$options['full_view'] = false;
$list = elgg_list_entities_from_metadata($options);
$options['count'] = true;
$count = elgg_get_entities_from_metadata($options);
elgg_set_context('plugins');

$title = elgg_echo('plugins:search:title');

// Add sidebar filter
$sidebar = elgg_view('plugins/filters', array(
	'categories' => $CONFIG->plugincats,
	'versions' => $CONFIG->elgg_versions,
	'licences' => $CONFIG->gpllicenses,
	'current_values' => $filters,
	'settings' => $settings,
));

// Add info block on search results to the main area
if ($count) {
	$first_index = $offset + 1;
	$last_index = min(array($offset + $limit, $count));
	$heading = elgg_view_title(sprintf(elgg_echo('plugins:search:results'), $count, $first_index, $last_index));
} else {
	$heading = elgg_view_title(elgg_echo('plugins:search:noresults'));
	$main = elgg_echo('plugins:search:noresults:info');
}

// Add the list of plugins to the main area
$main .= elgg_view('plugins/search/main', array('area1' => $list));

$body = elgg_view_layout('one_sidebar', array(
	'title' => $heading,
	'content' => $main, 
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);