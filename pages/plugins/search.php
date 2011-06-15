<?php

	/**
	 * Advanced search page, handling plugin filtering and sorting
	 */

    global $CONFIG;
    
    $offset = get_input('offset', 0);
    $limit = get_input('limit', 10);

    // Filters are passed as an associative, multidimensional array with shortened keys (to fit into IE's max URI length)
    $filters = get_input('f');

    // Default sort is time_created, descending order
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
            $key = sanitise_string($key);
            switch ($key) {
                case 't' :
                	// Any text value; will be matched against plugin title, description, summary, tags, author name and username
                	if (strlen($value) > 0) {
	                	$value = sanitise_string($value);
                        // Match title and description
	                	$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (e.guid = o.guid)";
						$fields = array('title', 'description');
						$wheres[] = search_get_where_sql('o', $fields, array('query' => $value, 'joins' => $options['joins']));
						
						//Match author name and username 
                        $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}users_entity u ON (e.owner_guid = u.guid)";
						$fields = array('username', 'name');
						$wheres[] = search_get_where_sql('u', $fields, array('query' => $value, 'joins' => $options['joins']));
						
						// Match summary and tags
						$value_parts = explode(' ', $value);
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metadata tm ON (e.guid = tm.entity_guid)";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings tm_name ON (tm.name_id = tm_name.id AND tm_name.string IN ('summary', 'tags'))";
	                    $options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}metastrings tm_value ON (tm.value_id = tm_value.id)";
	                    foreach ($value_parts as $expression) {
	                    	$wheres[] = "tm_value.string LIKE \"%$expression%\"";
	                    }
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
                	$options['joins'][] = "INNER JOIN {$CONFIG->dbprefix}entity_relationships r on (r.relationship=\"image\" AND r.guid_one = e.guid)";
                	break;
            }
        }
    }    

    // WHERE clauses were only added for full text search - so far all WHEREs can be safely joined by 'OR'
    if (!empty($wheres)) {
    	$options['wheres'] = array();
    	$options['wheres'][] = '(' . implode(' OR ', $wheres) . ')';
    }
	
    // Handle entity sorting
    // Duplicate join clauses will be removed by elgg_get_entities(), so no need to keep track of joins
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
    		$download_id = get_metastring_id('download', true);
    		$options['selects'] = array("count(a.entity_guid) as downloads");
    		$options['joins'][] = "LEFT JOIN {$CONFIG->dbprefix}annotations a on (e.guid = a.entity_guid AND a.name_id = $download_id)";
    		$options['group_by'] = "e.guid, a.entity_guid";
    		$options['order_by'] = "downloads {$direction}";
    		break;
    	case 'recommendations':
    		$digg_id = get_metastring_id('plugin_digg', true);
    		$options['selects'] = array("count(a.entity_guid) as recommendations");
    		$options['joins'][] = "LEFT JOIN {$CONFIG->dbprefix}annotations a on (e.guid = a.entity_guid AND a.name_id = $digg_id)";
    		$options['group_by'] = "e.guid, a.entity_guid";
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
    
	// Get objects
	set_context('search');
    $count = elgg_get_entities_from_metadata(array_merge($options, array('count' => true)));
    $entities = elgg_get_entities_from_metadata($options);
    $list = elgg_view_entity_list($entities, $count, $offset, $limit, false, false, true);
    set_context('plugins');

	$title = elgg_echo('plugins:search:title');
    
	// Add sidebar filter
	$sidebar = elgg_view('plugins/filters', array(
		'categories' => $CONFIG->plugincats,
		'versions' => $CONFIG->elgg_versions,
		'licences' => $CONFIG->gpllicenses,
		'current_values' => $filters
	));
	
	// Add info block on search results to the main area
	if ($count) {
		$first_index = $offset + 1;
		$last_index = $first_index + count($entities) - 1;
		$main = elgg_view_title(sprintf(elgg_echo('plugins:search:results'), $count, $first_index, $last_index));
	} else {
		$main = elgg_view_title(elgg_echo('plugins:search:noresults'));
		$main .= elgg_echo('plugins:search:noresults:info');
	}

	// Add the list of plugins to the main area
	$main .= elgg_view('plugins/search/main', array('area1' => $list));
	
	$body = elgg_view_layout('plugins_layout', $main, $sidebar);
	
	page_draw($title, $body);