<?php

/**
 * New plugin release river item
 */

$performed_by = get_entity($vars['item']->subject_guid);
$release = get_entity($vars['item']->object_guid);

$project = get_entity($release->container_guid);

$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
$string = sprintf(elgg_echo("plugins:river:release:created"), $url);
$string .= " <a href=\"" . $release->getURL() . "\">" . $project->title . "</a>";

echo $string;
