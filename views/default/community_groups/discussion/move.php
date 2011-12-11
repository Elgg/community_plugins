<?php
/**
 * The move discussion topic view
 *
 * @uses $vars['entity']
 */

echo '<h3>';
echo elgg_echo('cg:menu:move');
echo '</h3>';

echo elgg_view_form('discussion/move', array('class' => 'mal'), $vars);
