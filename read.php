<?php
/**
 * Temporary page since the page for viewing a plugin used to be hit directly
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

elgg_set_context('plugins');

system_message(elgg_echo('plugins:warning:page:all:bookmark'));

include dirname(__FILE__) . "/pages/plugins/view.php";
