<?php

	$statement = $vars['statement'];
	$performed_by = $statement->getSubject();
	$object = $statement->getObject();
	
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("plugins:river:annotate"),$url) . " ";
	$string .= "<a href=\"" . $object->getURL() . "\">" . elgg_echo("plugins:river:item") . "</a>";

	echo $string; 
	
?>