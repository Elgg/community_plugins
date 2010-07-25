<?php

// remove and update river items for new classes

$query = "DELETE from {$CONFIG->dbprefix}river WHERE view = 'river/object/plugins/update'";
delete_data($query);


$query = "UPDATE {$CONFIG->dbprefix}river
	SET view='river/object/plugin_project/create', subtype='plugin_project'
	WHERE view='river/object/plugins/create'";
update_data($query);