<?php
/**
 * Form for moving an off-topic post to a new topic
 */

$post = new ElggAnnotation($vars['id']);

echo '<p>';
echo '<label>' . elgg_echo('title') . '</label>';
echo elgg_view('input/text', array(
	'name' => 'title',
));
echo '</p>';

echo '<div>';
echo '<label>' . elgg_echo('cg:forum:offtopic:text') . '</label>';
echo elgg_view('output/longtext', array(
	'value' => $post->value,
));
echo '</div>';

echo elgg_view('input/hidden', array(
	'name' => 'id',
	'value' => $vars['id'],
));

echo elgg_view('input/submit', array('value' => elgg_echo('submit')));
