<?php
echo '<p>';
echo elgg_view('input/text', array('name' => 'guid'));
echo ' '; // yes, this should bs CSS
echo elgg_view('input/submit', array('value' => elgg_echo('submit')));
echo '</p>';
