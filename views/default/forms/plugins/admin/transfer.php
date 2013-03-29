<?php

echo "<b>Transfer ownership of the plugin to another user.</b>";

echo elgg_view('input/userpicker');

echo elgg_view('output/longtext', array(
	'value' => 'Begin typing the name of the user you wish to tranfer the plugin to and select them from the list.
	  Select only one user, if more than one is selected, only the first user selected will receive ownership.',
	'class' => 'elgg-subtext'
));

echo elgg_view('input/hidden', array('name' => 'project_guid', 'value' => $vars['project']->getGUID()));

echo elgg_view('input/submit', array('value' => 'Submit'));