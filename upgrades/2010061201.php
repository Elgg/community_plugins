<?php

// change subtype definition for plugin releases
$query = "UPDATE {$CONFIG->dbprefix}entity_subtypes
		SET subtype='plugin_release', class='PluginRelease'
		WHERE type='object' AND subtype='plugin_file'";
update_data($query);

// change subtype definition for plugin project
$query = "UPDATE {$CONFIG->dbprefix}entity_subtypes
		SET class='PluginProject'
		WHERE type='object' AND subtype='plugin_project'";
update_data($query);