<?php
/**
 * Initialize download counter
 */
?>
<br />
<h3>Initialize plugin download counter</h3>
<?php

$action = "{$vars['url']}action/plugins/init_counter/";

$form_body = elgg_view('input/submit', array('value' => elgg_echo('submit')));

echo elgg_view('input/form', array('body' => $form_body, 'action' => $action));
