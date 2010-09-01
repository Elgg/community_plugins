<?php

$guid = get_input('group_guid', 0);

set_plugin_setting('blog_group_guid', $guid, 'community_groups');

system_message('Setting saved');
forward(REFERER);