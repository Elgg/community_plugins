<?php

// change subtype definition for plugin releases
$query = "UPDATE {$CONFIG->dbprefix}entity_subtypes
		SET subtype='plugin_release', class='PluginRelease'
		WHERE type='object' AND subtype='plugin_file'";
update_data($query);