<?php
/**
 * Remove ad action
 */

$result = false;

$guid = get_input("guid");

if ($guid) {
	$topic = get_entity($guid);
	if ($topic) {
		$topic->description = elgg_echo('cg:form:ad:warning');
		$result = $topic->save();

		$poster = $topic->getOwnerEntity();
		$poster->ad_warnings = $poster->ad_warnings + 1;
	}
}

if ($result) {
	system_message(elgg_echo('cg:forum:removead:success'));
} else {
	register_error(elgg_echo('cg:forum:removead:error'));
}

forward(REFERER);
