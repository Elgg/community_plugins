<?php

//find groups
echo elgg_view("groups/find");

//menu options
echo elgg_view("community_groups/sidebar/menu");

echo elgg_view('community_groups/sidebar/howto', array('type' => 'groups'));

