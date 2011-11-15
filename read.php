<?php
/**
 * Temporary page since the page for viewing a plugin used to be hit directly
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

system_message('Please update your bookmark or report this link to the site owner as this page has moved.');

include dirname(__FILE__) . "/pages/plugins/read.php";
