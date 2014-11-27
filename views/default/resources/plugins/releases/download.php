<?php
/**
 * Download handler
 */

$project = get_entity(get_input("plugin"));
$release = get_entity(get_input('release'));

if (!$release || !$project || $release->container_guid != $project->guid) {
	register_error(elgg_echo("plugins:error:downloadfailed"));
	forward(REFERER);
}

$mime = "application/octet-stream";
$pluginname = $release->originalfilename;

header("Content-type: $mime");
header("Content-Disposition: attachment; filename=\"$pluginname\"");

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . $release->size());

//download counter on individual plugin and the plugin project
$release->updateDownloadCount();
$project->updateDownloadCount();

echo $release->grabFile();
exit;
