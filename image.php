<?php
/**
 * Serve plugin project images
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$guid = (int)get_input("guid");

$image = get_entity($guid);
if (!$image) {
	exit;
}

$mime = $image->getMimeType();

$filename = $image->originalfilename;

header("Content-type: $mime");
header("Content-Disposition: inline; filename=\"$filename\"");

$contents = $image->grabFile();
echo $contents;
