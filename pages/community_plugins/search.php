<?php

	/**
	 * Advanced search page, handling plugin filtering and sorting
	 */

    global $CONFIG;
    
    $offset = get_input('offset', 0);
    $limit = get_input('limit', 10);

    // Filters are passed as an associative, multidimensional array with shortened keys (to fit into IE's max URI length)
    $filters = get_input('f');

    // Default sort is time_createad, descending
    $sort = get_input('sort', 'created');
    $direction = get_input('direction', 'desc');

    $options = array(
    	'type'						=> 'object',
    	'subtype'                   => 'plugin_project',
        'offset'                    => $offset,
        'limit'                     => $limit,
        'metadata_name_value_pairs'	=> array(),
        'metadata_case_sensitive'   => false,
    	'joins'						=> array(),
    );
    $wheres = array();

    // Handle entity filtering
    if (is_array($filters) && !empty($filters)) {
        foreach ($filters as $key => $value) {
            $key = mysql_real_escape_string($key);
            switch ($key) {
                case 't' :
                	// Any text value, will be matched against plugin title, description, summary, author name and username
                	if (strlen($value) > 0) {
	                	$value = mysql_real_escape_string($value);
                        $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (e.guid = o.guid)";
						$fields = array('title', 'description');
						$wheres[] = search_get_where_sql('o', $fields, array('query' => $value, 'joins' => $options['joins']));
                        $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}users_entity u ON (e.owner_guid = u.guid)";
						$fields = array('username', 'name');
						$wheres[] = search_get_where_sql('u', $fields, array('query' => $value, 'joins' => $options['joins']));
                    }
                    break;
                case 'c' :
                	// Categories
                	if (is_array($value) && !empty($value)) {
                		$options['metadata_name_value_pairs'][] = array("name" => 'plugincat', "value" => $value, "operand" => "IN");
                	}
                    break;
                case 'l' :
                	// Licences
                	if (is_array($value) && !empty($value)) {
                		$options['metadata_name_value_pairs'][] = array("name" => 'license', "value" => $value, "operand" => "IN");
                	}
                    break;
                case 'v' :
                	// Elgg versions
                	if (is_array($value) && !empty($value)) {
                		$versions = '("' . implode('","', $value) . '")';
                		$plugin_release_subtype = get_subtype_id('object', 'plugin_release');
                		$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}entities pre ON (e.guid = pre.container_guid AND pre.subtype = $plugin_release_subtype)";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metadata prm ON (pre.guid = prm.entity_guid)";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings prm_name ON (prm.name_id = prm_name.id AND prm_name.string = 'elgg_version')";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings prm_value ON (prm.value_id = prm_value.id AND prm_value.string IN $versions)";
                	}
                	break;
                case 's' :
                	// Only with screenshot
                	/*
                	if (is_array($value) && !empty($value)) {
                		$versions = '("' . implode('","', $value) . '")';
                		$plugin_release_subtype = get_subtype_id('object', 'plugin_release');
                		$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}entities pre ON (e.guid = pre.container_guid AND pre.subtype = $plugin_release_subtype)";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metadata prm ON (pre.guid = prm.entity_guid)";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings prm_name ON (prm.name_id = prm_name.id AND prm_name.string = 'elgg_version')";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings prm_value ON (prm.value_id = prm_value.id AND prm_value.string IN $versions)";
                	}
                	*/
                	break;
            }
        }
    }    

    // WHERE clauses will only be added for full text search - so all wheres can be safely joined by 'OR'
    if (!empty($wheres)) {
    	$options['wheres'] = array();
    	$options['wheres'][] = '(' . implode(' OR ', $wheres) . ')';
    }
	
	// Get objects
	set_context('search');
    $count = elgg_get_entities_from_metadata(array_merge($options, array('count' => true)));
    $entities = elgg_get_entities_from_metadata($options);
    $list = elgg_view_entity_list($entities, $count, $offset, $limit, false, false, true);
    set_context('plugins');

	$title = sprintf(elgg_echo('plugins:category:title'), $category_label);
    
	$sidebar = elgg_view('plugins/filters', array(
		'categories' => $CONFIG->plugincats,
		'versions' => $CONFIG->elgg_versions,
		'licences' => $CONFIG->gpllicenses,
		'current_values' => $filters
	));
	
	$main = elgg_view('plugins/search/main', array('area1' => $list));
	
	$body = elgg_view_layout('plugins_layout', $main, $sidebar);
	
	page_draw($title, $body);
