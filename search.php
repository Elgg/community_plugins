<?php
/**
 * Old category listing page - moved to category_list.php
 *
 * This is here until no one is hitting it directly anymore or a rewrite rule
 * is set up for it.
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

system_message('Please update your bookmark or report this link to the site owner as this page has moved.');

include dirname(__FILE__) . "/pages/plugins/category_list.php";
