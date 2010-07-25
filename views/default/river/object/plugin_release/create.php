<?php

/**
 * New plugin release river item
 */

$performed_by = get_entity($vars['item']->subject_guid);
$object = get_entity($vars['item']->object_guid);
$url = $object->getURL();

$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
$string = sprintf(elgg_echo("plugins:river:release:created"), $url);
$string .= " <a href=\"" . $object->getURL() . "\">" . $object->title . "</a>";

echo $string;

