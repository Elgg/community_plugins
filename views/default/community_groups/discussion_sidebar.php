<?php


//featured groups
$featured_groups = elgg_get_entities_from_metadata(array('metadata_name' => 'featured_group', 'metadata_value' => 'yes', 'types' => 'group', 'limit' => 10));
echo elgg_view("groups/featured", array("featured" => $featured_groups));
