<?php
/**
 * Form for moving an off-topic post to a new topic
 */

$post = get_annotation($vars['post_id']);

echo '<div class="contentWrapper">';

echo '<p>';
echo '<label>' . elgg_echo('title') . '</label>';
echo elgg_view('input/text', array(
	'internalname' => 'title',
));
echo '</p>';

echo '<div>';
echo '<label>' . elgg_echo('cg:forum:offtopic:text') . '</label>';
echo elgg_view('output/longtext', array(
	'value' => $post->value,
));
echo '</div>';

echo elgg_view('input/hidden', array(
	'internalname' => 'group_guid',
	'value' => $vars['group_guid'],
));

echo elgg_view('input/hidden', array(
	'internalname' => 'user_guid',
	'value' => $post->owner_guid,
));

echo elgg_view('input/hidden', array(
	'internalname' => 'post_id',
	'value' => $vars['post_id'],
));

echo elgg_view('input/submit', array('value' => elgg_echo('submit')));

echo '</div>';
