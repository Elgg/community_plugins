<?php

$ia = elgg_set_ignore_access(true);

$guid = get_input('plugin');
$project = get_entity($guid);

try {
	if (!$project instanceof PluginProject) {
		throw new \Elgg\CommunityPlugins\HttpException('Plugin project not found', 404);
	}

	$release = $project->digestGithubPayload();

	header('HTTP/1.1 200 OK');
	if ($release instanceof ElggObject) {
		header('Content-Type: application/json');
		echo json_encode($release->toObject());
	}
} catch (\Elgg\CommunityPlugins\HttpException $ex) {

	$http_codes = array(
		'400' => 'Bad Request',
		'401' => 'Unauthorized',
		'403' => 'Forbidden',
		'404' => 'Not Found',
		'407' => 'Proxy Authentication Required',
		'500' => 'Internal Server Error',
		'503' => 'Service Unavailable',
	);
	$code = (string) $ex->getCode();
	if (!isset($http_codes[$code])) {
		$code = '500';
	}
	$message = $https_codes[$code];
	header("HTTP/1.1 $code $message");
	echo $ex->getMessage();
} catch (Exception $ex) {
	header('HTTP/1.1 500 Internal Server Error');
	echo $ex->getMessage();
}

elgg_set_ignore_access($ia);

exit;
