<?php
/**
 * Form for moving an off-topic post to a new topic
 */

$post = get_entity($vars['guid']);

echo '<p>';
echo '<label>' . elgg_echo('title') . '</label>';
echo elgg_view('input/text', array(
	'name' => 'title',
));
echo '</p>';

echo '<div>';
echo '<label>' . elgg_echo('cg:forum:offtopic:text') . '</label>';
echo elgg_view('output/longtext', array(
	'value' => $post->description,
));
echo '</div>';

echo elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $vars['guid'],
));

echo elgg_view('input/submit', array('value' => elgg_echo('submit')));
