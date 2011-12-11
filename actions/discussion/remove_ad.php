<?php
/**
 * Remove ad action
 */

$result = false;

$guid = get_input("guid");
$id = get_input("id");

if ($guid) {
	$topic = get_entity($guid);
	if ($topic) {
		$topic->description = elgg_echo('cg:form:ad:warning');
		$result = $topic->save();

		$poster = $topic->getOwnerEntity();
		$poster->ad_warnings = $poster->ad_warnings + 1;
	}
} else if ($id) {
	$reply = new ElggAnnotation($id);
	if ($reply) {
		$warning = elgg_echo('cg:form:ad:warning');
		$comment_owner = $reply->owner_guid;
		$access_id = $reply->access_id;
		$result = update_annotation($id, "group_topic_post", $warning, '', $comment_owner, $access_id);
		$poster = $reply->getOwnerEntity();
		$poster->ad_warnings = $poster->ad_warnings + 1;
	}
}

if ($result) {
	system_message(elgg_echo('cg:forum:removead:success'));
} else {
	
}

forward(REFERER);
