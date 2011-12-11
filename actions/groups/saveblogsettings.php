<?php
/**
 * save blog group integration settings
 */

$guid = get_input('group_guid', 0);

elgg_set_plugin_setting('blog_group_guid', $guid, 'community_groups');

system_message('Setting saved');
forward(REFERER);
