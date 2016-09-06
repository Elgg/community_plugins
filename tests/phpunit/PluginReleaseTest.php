<?php

class PluginReleaseTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var PluginRelease
	 */
	private $release;

	public function setUp() {

		$release = new PluginRelease();
		$release->owner_guid = 1;
		$release->setFilename('plugin-1.0.zip');

		$this->release = $release;
	}

	public function tearDown() {
		
	}

	public function testCanGetManifest() {
		$manifest = $this->release->getManifest();
		$expected = file_get_contents(elgg_get_config('dataroot') . 'plugin-1.0/wrapper-folder/plugin/manifest.xml');
		$this->assertEquals(new ElggPluginManifest($expected, 'plugin'), $manifest);
	}

	public function testCanGetSupportedElggVersions() {
		$expected = ['1.12', '1.11', '1.10', '1.9'];
		$actual = $this->release->getSupportedElggVersions();
		$this->assertEquals($expected, $actual);
	}

	public function testCanSetHash() {
		$expected = md5('plugin' . '1.0' . 'PHPUnit');
		$this->release->setHash();
		$this->assertEquals($expected, $this->release->hash);
	}
}
