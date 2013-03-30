<?php

echo "<b>List users as contributors to this plugin</b>";

echo elgg_view('input/userpicker');

echo elgg_view('output/longtext', array(
'value' => "Adding users as contributors <b>does not</b> give them any special privileges with regard to the plugin page, it does however list them as contributing members.
  It is a way of recognizing community members for their collaborative work of reporting bugs, and submitting patches for bugfixes and enhancements.
  Begin typing the name of the user who has contributed to the plugin.  You can select as many users as necessary.",
'class' => 'elgg-subtext'
));

echo elgg_view('input/hidden', array('name' => 'project_guid', 'value' => $vars['project']->getGUID()));

echo elgg_view('input/submit', array('value' => 'Submit'));