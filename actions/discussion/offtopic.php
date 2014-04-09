<?php
/**
 * Create a new topic for an off-topic posting
 *
 * This also inserts a warning about the off topic posting
 */

$guid = get_input('guid');
$title = get_input('title');

$reply = get_entity($guid);
$original_topic = $reply->getContainerEntity();
$user_guid = $reply->getOwnerGUID();
$group_guid = $original_topic->getContainerGUID();

$grouptopic = new ElggObject();
$grouptopic->subtype = "groupforumtopic";
$grouptopic->owner_guid = $user_guid;
$grouptopic->container_guid = $group_guid;
$grouptopic->access_id = $original_topic->access_id;
$grouptopic->title = $title;
$grouptopic->description = $reply->description;
$grouptopic->status = 'open';
if (!$grouptopic->save()) {
	register_error(elgg_echo("grouptopic:error"));
	forward(REFERER);
}

elgg_delete_river(array('object_guid' => $reply->guid));

elgg_create_river_item(array(
	'view' => 'river/object/groupforumtopic/create',
	'action_type' => 'create',
	'subject_guid' => $user_guid,
	'object_guid' => $grouptopic->guid,
	'posted' => $reply->time_created
));

// Add a warning text to the end of the original post
$warning_text = elgg_echo('cg:form:offtopic:warning');
$new_text = "{$reply->description}<p>[{$warning_text}]</p>";
$reply->description = $new_text;
$reply->save();

system_message(elgg_echo('cg:forum:offtopic:success'));
forward($grouptopic->getURL());
