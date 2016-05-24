<?php

namespace Elgg\CommunityPlugins;

class HttpClient {

	/**
	 * Fetch remote URL
	 * 
	 * @param string $url URL to fetch
	 * @return string
	 */
	public function get($url) {

		$ch = curl_init();
		$version = curl_version();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, "curl/{$version['version']}");
		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

}
