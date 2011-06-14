<?php

	/**
	 * Advanced search page, handling plugin filtering and sorting
	 */

    global $CONFIG;
    
    $offset = get_input('offset', 0);
    $limit = get_input('limit', 10);
    $filters = get_input('filters');
    $sort = get_input('sort', 'created');
    $direction = get_input('direction', 'desc');

    $options = array(
    	'type'						=> 'object',
    	'subtype'                   => 'plugin_project',
        'offset'                    => $offset,
        'limit'                     => $limit,
        'metadata_name_value_pairs'	=> array(),
        'metadata_case_sensitive'   => false,
    );
    $joins = array();

        // Handle entity filtering
    if (is_array($filters) && !empty($filters)) {
        foreach ($filters as $key => $value) {
            $key = mysql_real_escape_string($key);
            switch ($key) {
                case 'text' :
                	/*
                	if (strlen($value) > 0) {
	                	$value = mysql_real_escape_string($value);
                        if (empty($joins['users'])) {
                            $joins['users'] = array();
                        }
                        $joins['users'][] = "join {$CONFIG->dbprefix}users_entity u on (e.guid = u.guid)";
                        if (empty($options['wheres'])) {
                            $options['wheres'] = array();
                        }
                        $options['wheres'][] = "(u.{$key} LIKE '%{$value}%')";
                    }
                    */
                    break;
                case 'categories' :
                	if (is_array($value) && !empty($value)) {
                		$options['metadata_name_value_pairs'][] = array("name" => 'plugincat', "value" => $value, "operand" => "IN");
                	}
                    break;
                case 'licences' :
                	if (is_array($value) && !empty($value)) {
                		$options['metadata_name_value_pairs'][] = array("name" => 'license', "value" => $value, "operand" => "IN");
                	}
                    break;
                case 'versions' :
                	if (is_array($value) && !empty($value)) {
                		$versions = '("' . implode('","', $value) . '")';
                		$plugin_release_subtype = get_subtype_id('object', 'plugin_release');
                		$joins[] = "INNER JOIN {$CONFIG->dbprefix}entities pre ON (e.guid = pre.container_guid AND pre.subtype = $plugin_release_subtype)";
	                    $joins[] = "INNER JOIN {$CONFIG->dbprefix}metadata prm ON (pre.guid = prm.entity_guid)";
	                    $joins[] = "INNER JOIN {$CONFIG->dbprefix}metastrings prm_name ON (prm.name_id = prm_name.id AND prm_name.string = 'elgg_version')";
	                    $joins[] = "INNER JOIN {$CONFIG->dbprefix}metastrings prm_value ON (prm.value_id = prm_value.id AND prm_value.string IN $versions)";
                	}
                	break;
            }
        }
    }    

    if (!empty($joins)) {
        $options['joins'] = $joins;
    }
    
	$title = sprintf(elgg_echo('plugins:category:title'), $category_label);
	
	// Get objects
	set_context('search');
	
    $count = elgg_get_entities_from_metadata(array_merge($options, array('count' => true)));
    $entities = elgg_get_entities_from_metadata($options);
    $list = elgg_view_entity_list($entities, $count, $offset, $limit, false, false, true);
    
		
	set_context('plugins');
	
	$sidebar = elgg_view('plugins/filters', array(
		'categories' => $CONFIG->plugincats,
		'versions' => $CONFIG->elgg_versions,
		'licences' => $CONFIG->gpllicenses
	));
	
	$main = elgg_view('plugins/search/main', array('area1' => $list));
	
	$body = elgg_view_layout('plugins_layout', $main, $sidebar);
	
	page_draw($title, $body);
