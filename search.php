<?php
/**
 * Old category listing page - moved to category_list.php
 *
 * This is here until no one is hitting it directly anymore or a rewrite rule
 * is set up for it.
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

elgg_set_context('plugins');

system_message(elgg_echo('plugins:warning:page:all:bookmark'));

include dirname(__FILE__) . "/pages/plugins/category_list.php";
