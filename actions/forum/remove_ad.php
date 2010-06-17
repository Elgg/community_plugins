<?php

$post = get_input("post");

$annotation = get_annotation($post);
if (!$annotation) {
	register_error();
	forward(REFERER);
}

$comment_owner = $annotation->owner_guid;
$access_id = $annotation->access_id;

$warning = elgg_echo('cg:form:ad:warning');

update_annotation($post, "group_topic_post", $warning, '', $comment_owner, $access_id);

// increment number of warnings for this user
$commenter = get_user($comment_owner);
$commenter->ad_warnings = $commenter->ad_warnings + 1;


system_message(elgg_echo('cg:forum:removead:success'));

forward(REFERER);
