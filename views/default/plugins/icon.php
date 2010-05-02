<?php
	/**
	 * Elgg file icons.
	 * Displays an icon, depending on its mime type, for a file. 
	 * Optionally you can specify a size.
	 * 
	 * @package ElggFile
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	global $CONFIG;
	
	$mime = $vars['mimetype'];
	if (isset($vars['thumbnail'])) {
		$thumbnail = $vars['thumbnail'];
	} else {
		$thumbnail = false;
	}
	
	$size = $vars['size'];
	if ($size != 'large') {
		$size = 'small';
	}
	
	// Handle 
	switch ($mime)
	{
		case 'image/jpg' 	:
		case 'image/jpeg' 	:
		case 'image/png' 	:
		case 'image/gif' 	:
		case 'image/bmp' 	: 
			//$file = get_entity($file_guid);
			if ($thumbnail)
				echo "<img src=\"{$vars['url']}action/plugins/icon?file_guid={$vars['plugins_guid']}\" border=\"0\" />";
			else 
			{
				if ($size == 'large') {
					echo "<img src=\"{$CONFIG->wwwroot}mod/community_plugins/graphics/icons/general_lrg.gif\" border=\"0\" />";
				} else {
					echo "<img src=\"{$CONFIG->wwwroot}mod/community_plugins/graphics/icons/general.gif\" border=\"0\" />";
				}
			}
			
		break;
		default :
			if (!empty($mime) && elgg_view_exists("plugins/icon/{$mime}", $vars)) {
				echo elgg_view("plugins/icon/{$mime}", $vars);
			} else if (!empty($mime) && elgg_view_exists("plugins/icon/" . substr($mime,0,strpos($mime,'/')) . "/default", $vars)) {
				echo elgg_view("plugins/icon/" . substr($mime,0,strpos($mime,'/')) . "/default", $vars);
			} else {
				echo "<img src=\"{$CONFIG->wwwroot}mod/community_plugins/graphics/icons/general.gif\" border=\"0\" />";
			}	 
		break;
	}

?>