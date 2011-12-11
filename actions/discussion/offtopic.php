<?php
/**
 * Create a new topic for an off-topic posting
 *
 * This also inserts a warning about the off topic posting
 */

$id = get_input('id');
$title = get_input('title');

$reply = new ElggAnnotation($id);
$original_topic = $reply->getEntity();
$user_guid = $reply->getOwnerGUID();
$group_guid = $original_topic->getContainerGUID();

$grouptopic = new ElggObject();
$grouptopic->subtype = "groupforumtopic";
$grouptopic->owner_guid = $user_guid;
$grouptopic->container_guid = $group_guid;
$grouptopic->access_id = $original_topic->access_id;
$grouptopic->title = $title;
$grouptopic->description = $reply->value;
$grouptopic->status = 'open';
if (!$grouptopic->save()) {
	register_error(elgg_echo("grouptopic:error"));
	forward(REFERER);
}

remove_from_river_by_annotation($reply->id);
add_to_river('river/object/groupforumtopic/create', 'create', $user_guid, $grouptopic->guid, $grouptopic->access_id, $original_topic->getTimeCreated());

$new_text = $reply->value;
$new_text .= '<p>[' . elgg_echo('cg:form:offtopic:warning') . ']</p>';
update_annotation($reply->id, 'group_topic_post', $new_text, $reply->value_type, $reply->owner_guid, $reply->access_id);

system_message(elgg_echo('cg:forum:offtopic:success'));
forward($grouptopic->getURL());
