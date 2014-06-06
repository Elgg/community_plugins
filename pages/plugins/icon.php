<?php
/**
 * Serve plugin project images
 */

$image = get_entity(get_input("icon"));
if (!$image) {
	exit;
}

$filename = $image->originalfilename;
$filelocation = $image->getFilenameOnFilestore();
$size = @filesize($filelocation);
header("Content-Disposition: inline; filename=\"$filename\"");
header("Content-type: image/jpeg");
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: $size");
readfile($filelocation);
exit;

