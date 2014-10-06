<?php

namespace Elgg\CommunityPlugins;

class UriTemplateTest extends \PHPUnit_Framework_TestCase {
	public function testReturnsNullForNoMatch() {
		$tpl = new UriTemplate("/blog");
		
		$result = $tpl->match("/foo");
		
		$this->assertNull($result);
	}

	public function testCanMatchExactMatches() {
		$tpl = new UriTemplate("/blog");
		
		$result = $tpl->match("/blog");
		
		$this->assertEquals(array(), $result);
	}
	
	public function testCanMatchNamedParameters() {
		$tpl = new UriTemplate("/blog/{guid}");
		
		$result = $tpl->match("/blog/12345");
		
		$this->assertEquals(array('guid' => '12345'), $result);
	}
}