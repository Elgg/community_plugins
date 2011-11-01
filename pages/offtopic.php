<?php
/**
 * Promote a forum reply to a new topic
 *
 * To be used for off-topic posts
 */

admin_gatekeeper();

$title = elgg_echo('cg:forum:offtopic:title');

$page_owner = set_page_owner((int) get_input('group_guid'));
if (!(page_owner_entity() instanceof ElggGroup)) {
	forward();
}

$form_body = elgg_view("forms/forums/offtopic", array(
	'group_guid' => get_input('group_guid'),
	'post_id' => get_input('post_id'),
));
$form = elgg_view('input/form', array(
	'action' => get_config('wwwroot') . 'action/forum/offtopic',
	'method' => 'post',
	'body' => $form_body,
));

$content = elgg_view_title($title);
$content .= $form;

$body = elgg_view_layout('two_column_left_sidebar', '', $content);

page_draw($title, $body);
