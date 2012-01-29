<?php
echo '<p>';
echo 'GUID of plugin project that is be replaced in the combination';
echo elgg_view('input/text', array('name' => 'old_guid'));
echo '</p>';

echo '<p>';
echo 'GUID of plugin project that remains in the combination';
echo elgg_view('input/text', array('name' => 'new_guid'));
echo '</p>';

echo elgg_view('input/submit', array('value' => elgg_echo('submit')));
