<?php

$offset = get_input('offset', 0);

$categories = get_input('category');

foreach ($categories as $guid=>$category) {
	create_metadata($guid, 'group_category', $category, 'text', $guid, ACCESS_PUBLIC);
}

system_message(elgg_echo('cg:groups:categorize:success'));
forward("pg/groupsadmin/categorize/?offset=$offset");