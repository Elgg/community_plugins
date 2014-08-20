<?php
/**
 * Serve plugin project images
 */

// This allows adding the plugin in mod/ using a symbolic link
$filepath = $_SERVER['SCRIPT_FILENAME'];

$elgg_root = dirname(dirname(dirname($filepath)));

require_once("{$elgg_root}/engine/settings.php");
require_once("{$elgg_root}/engine/classes/Elgg/EntityDirLocator.php");

$owner_guid = (int) $_GET['owner_guid'];
$filename = $_GET['name'];

$locator = new Elgg_EntityDirLocator($owner_guid);
$path = $locator->getPath();

$filelocation = "{$CONFIG->dataroot}{$path}plugins/$filename";

$size = @filesize($filelocation);
header("Content-Disposition: inline; filename=\"$filename\"");
header("Content-type: image/jpeg");
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: $size");
readfile($filelocation);
exit;
