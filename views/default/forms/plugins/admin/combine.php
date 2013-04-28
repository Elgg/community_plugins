<?php
echo '<p>';
echo elgg_echo('plugins:admin:combine:old_guid');
echo elgg_view('input/text', array('name' => 'old_guid'));
echo '</p>';

echo '<p>';
echo elgg_echo('plugins:admin:combine:new_guid');
echo elgg_view('input/text', array('name' => 'new_guid'));
echo '</p>';

echo elgg_view('input/submit', array('value' => elgg_echo('submit')));
