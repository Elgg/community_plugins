<?php
/**
 * Elgg file browser download action.
 */

// Get the guid
$file_guid = get_input("plugins_guid");
	
// Get the file
$file = get_entity($file_guid);
	
if ($file){
	$mime = $file->getMimeType();
	if (!$mime) $mime = "application/octet-stream";
		
	$filename = $file->thumbnail;
		
	header("Content-type: $mime");
	if (strpos($mime, "image/")!==false)
		header("Content-Disposition: inline; filename=\"$filename\"");
	else
		header("Content-Disposition: attachment; filename=\"$filename\"");

			
	$readfile = new ElggFile();
	$readfile->owner_guid = $file->owner_guid;
	$readfile->setFilename($filename);
	
	$contents = $readfile->grabFile();
	if (empty($contents)) {
		echo file_get_contents(dirname(dirname(__FILE__)) . "/graphics/icons/general.jpg" );
	} else {
		echo $contents;
	}
	exit;
}else
	register_error(elgg_echo("plugins:downloadfailed"));