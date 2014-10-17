<?php

$description = elgg_view('input/longtext', array(
	'name' => 'description',
));

$project_guid = elgg_view('input/hidden', array(
	'name' => 'project_guid',
	'value' => $vars['project']->getGUID()
));

$submit = elgg_view('input/submit', array(
	'value' => elgg_echo('request')
));

echo <<<FORM
	<div>
		$description
	</div>
	<div>
		$project_guid
		$submit
	</div>
FORM;
