<?php

namespace Elgg\CommunityPlugins;

/**
 * Adapter to retrieve data from github API
 */
class GithubService {

	/**
	 * @var HttpClient
	 */
	private $http_client;

	const BASE_URL = "https://api.github.com/";

	/**
	 * Constructor
	 *
	 * @param \Elgg\CommunityPlugins\HttpClient $http_client HttpClient
	 */
	public function __construct(HttpClient $http_client = null) {
		if (!isset($http_client)) {
			$http_client = new HttpClient();
		}
		$this->http_client = $http_client;
	}

	/**
	 * Fetch data from Github API endpoint
	 *
	 * @param string $endpoint Endpoint
	 * @return array|false
	 */
	public function fetch($endpoint) {

		$endpoint = trim($endpoint, '/');
		$url = self::BASE_URL . $endpoint;

		$response = $this->http_client->get($url);

		if (!$response) {
			return false;
		}

		$response = json_decode($response, true);
		if (isset($response['message'])) {
			elgg_log("GithubAPI Error: {$response['message']}");
			return false;
		}

		return $response;
	}

	/**
	 * Get a list of releases
	 *
	 * @param string $owner Github repository owner
	 * @param string $repo  Github repository name
	 * @return array|false
	 */
	public function getReleases($owner, $repo) {
		return $this->fetch("repos/$owner/$repo/releases");
	}

	/**
	 * Get release info
	 *
	 * @param string $owner Github repository owner
	 * @param string $repo  Github repository name
	 * @param string $id Release id
	 * @return array|false
	 */
	public function getRelease($owner, $repo, $id) {
		return $this->fetch("repos/$owner/$repo/releases/$id");
	}

	/**
	 * Validate and unserialize webhook payload
	 *
	 * @param string $secret Secret key
	 * @return array|false
	 * @throws SecurityException
	 */
	public function filterPayload($secret = '') {

		$request = _elgg_services()->request;

		$signature = $request->headers->get('X-Hub-Signature');
		list($algo, $hash) = explode('=', $signature, 2);

		$payload = $request->getContent();

		$hmac = hash_hmac($algo, $payload, $secret);
		
		if (!_elgg_services()->crypto->areEqual($hmac, $hash)) {
			throw new \SecurityException('Token mismatch');
		}

		return json_decode($payload, true);
	}

}
