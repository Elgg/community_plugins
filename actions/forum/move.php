<?php

$group_guid = get_input('group_guid');
$post_guid = get_input('post_guid');

$post = get_entity($post_guid);

if (!$post || $group_guid == 0) {
	register_error(elgg_echo('cg:forum:move:error'));
	forward(REFERER);
}

$orig_group_guid = $post->container_guid;

$post->container_guid = $group_guid;
$post->save();

system_message(elgg_echo('cg:forum:move:success'));
forward("{$CONFIG->url}pg/groups/forum/$orig_group_guid/");
