<?php

namespace Elgg\CommunityPlugins;


/**
 * Represents a pattern for a URI with named parameters.
 * 
 * Examples:
 *  * "/blog" (matches only "/blog" exactly)
 *  * "/blog/{name}" (matches "/blog/anything" but not "/blog/anything/more")
 */
class UriTemplate {
	
	/** @type string */
	private $template;
	
	/**
	 * @param string $template
	 */
	public function __construct($template) {
		$this->template = $template;
	}
	
	
	/**
	 * @example
	 * 
	 * 	$template = new UriTemplate("/foo/{bar}")
	 * 	$result = $template->match("/foo/baz")
	 * 
	 * 	// $result == array('bar' => 'baz')
	 * 
	 * @example
	 * 
	 * 	$template = new UriTemplate("/foo/{bar}")
	 * 	$result = $template->match("/baz/bop")
	 * 
	 * 	// $result == NULL
	 * 
	 * 
	 * @param string $string The URI to match against
	 * 
	 * @return null|array Null if not a match, otherwise associative array of
	 *                    matching parameters.
	 */
	public function match($string) {
		// Convert {name} shorthand to regex for matching against $path
		// E.g., "/blog/{guid}" => "/blog/(?<guid>[^/]+)"
		$regex = preg_replace('/\{([a-z_]+)\}/', '(?<$1>[^/]+)', $this->template);
		
		$matches = array();
		// TODO(ewinslow): This fails to support uris with the # in them
		$count = preg_match("#^$regex$#", $string, $matches);
		if (!$count) {
			return null;
		}
		
		// We want to keep just the named parameters, so:
		// Convert: array(0 => '/blog/12345', 1 => 12345, 'guid' => 12345)
		// To:      array('guid' => 12345)
		$result = array();
		foreach ($matches as $key => $value) {
			if (!is_int($key)) {
				$result[$key] = $value;
			}
		}
		return $result;
	}
}