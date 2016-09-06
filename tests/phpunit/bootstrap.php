<?php

$plugin_root = dirname(dirname(dirname(__FILE__)));
$root = dirname(dirname($plugin_root));
require_once $root . '/engine/tests/phpunit/bootstrap.php';
require_once $plugin_root . '/vendor/autoload.php';

elgg_set_config('dataroot', __DIR__ . '/test_files/');

// Reinitialize filestore to point to new dataroot
_elgg_filestore_init();

// Elgg versions (The forms expect this to be an associative array)
elgg_set_config('elgg_versions', array(
	'2.1' => '2.1',
	'2.0' => '2.0',
	'1.12' => '1.12',
	'1.11' => '1.11',
	'1.10' => '1.10',
	'1.9' => '1.9',
	'1.8' => '1.8',
	'1.7' => '1.7',
	'1.6' => '1.6',
	'1.5' => '1.5',
	'1.2' => '1.2',
	'1.0' => '1.0',
));
