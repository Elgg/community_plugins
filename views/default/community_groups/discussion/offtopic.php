<?php
/**
 * Promote a reply to its own topic
 *
 * @uses $vars['id']
 */

echo '<h3>';
echo elgg_echo('cg:forum:offtopic:title');
echo '</h3>';

echo elgg_view_form('discussion/offtopic', array('class' => 'mal'), $vars);
