<?php
/**
 * Download handler
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$release = get_entity(get_input("release_guid"));
$project = get_entity($release->container_guid);

if (!$release || !$project) {
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
header("Content-Length: ".$release->size());

//download counter on individual plugin and the plugin project
$release->incrementDownloadCount();
$project->incrementDownloadCount();

// add to site downloads so they won't disappear when a plugin is deleted.
$ia = elgg_set_ignore_access(TRUE);
$CONFIG->site->plugins_download_count = $CONFIG->site->plugins_download_count + 1;
elgg_set_ignore_access($ia);

echo $release->grabFile();
exit;
