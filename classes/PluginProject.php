<?php

use Elgg\CommunityPlugins\GithubService;
use Elgg\CommunityPlugins\HttpClient;
use Elgg\Filesystem\MimeTypeDetector;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Models the concept of a plugin. Handles revisions with PluginRelease objects.
 * 
 * @property int    $recommended_release_guid GUID of the author-recommended release for this plugin.
 * @property string $github_owner             Owner of the github repository
 * @property string $github_repo              Name of the github repository
 * @property int    $github_access_id         Access ID of releases imported from Github
 * @property string $github_comments          Allows comments on releases imported from Github
 */
class PluginProject extends ElggObject {

	/**
	 * @var PluginRelease
	 */
	private $latest_release;

	/**
	 * @var PluginRelease
	 */
	private $recommended_release;

	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "plugin_project";
	}

	/**
	 * Has the current user has dugg the plugin project
	 * @return bool
	 * @todo Use likes instead?
	 */
	public function isDugg() {
		return !!check_entity_relationship(elgg_get_logged_in_user_guid(), "has_dugg", $this->guid);
	}

	public function addDigg() {
		return add_entity_relationship(elgg_get_logged_in_user_guid(), 'has_dugg', $this->guid);
	}

	/** @return int */
	public function countDiggs() {
		return $this->countAnnotations('plugin_digg');
	}

	/** @return array */
	public function getScreenshots() {
		return elgg_get_entities_from_relationship(array(
			'relationship_guid' => $this->getGUID(),
			'relationship' => 'image',
			'order_by' => 'guid',
		));
	}

	/**
	 * @return PluginRelease The most recently uploaded version of this plugin.
	 */
	public function getLatestRelease() {
		if (isset($this->latest_release)) {
			return $this->latest_release;
		}

		$releases = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'plugin_release',
			'container_guid' => $this->guid,
			'limit' => 1,
		));

		return $this->latest_release = $releases[0];
	}

	/**
	 * @param string $version The version number to look for (e.g., '1.3.2')
	 * @return PluginRelease The release of this plugin that matches the specified version.
	 */
	public function getReleaseFromVersion($version) {
		$releases = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'plugin_release',
			'container_guid' => $this->guid,
			'metadata_name' => 'version',
			'metadata_value' => $version,
			'limit' => 1,
		));

		return $releases[0];
	}

	/**
	 * @return ElggRelease The author-recommended version of this plugin.
	 *
	 * @todo This probably shouldn't return the latest release by default.
	 * Those are two different concepts.
	 */
	public function getRecommendedRelease($elgg_version) {
		if (isset($this->recommended_release[$elgg_version])) {
			return $this->recommended_release[$elgg_version];
		}

		$releases = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'plugin_release',
			'container_guid' => $this->guid,
			'metadata_name_value_pairs' => array(
				'name' => 'recommended',
				'value' => $elgg_version
			),
			'limit' => 1
		));

		if ($releases) {
			$this->recommended_release[$elgg_version] = $releases[0];
			return $releases[0];
		}

		$this->recommended_release[$elgg_version] = $this->getRecentReleaseByElggVersion($elgg_version);
		return $this->recommended_release[$elgg_version];
	}

	/**
	 * Get the most recent release for an elgg version
	 * @param string $elgg_version
	 */
	public function getRecentReleaseByElggVersion($elgg_version) {
		$options = array(
			'type' => 'object',
			'subtype' => 'plugin_release',
			'container_guid' => $this->guid,
			'metadata_name_value_pairs' => array(
				'name' => 'elgg_version',
				'value' => $elgg_version
			),
			'limit' => 1
		);

		$releases = elgg_get_entities_from_metadata($options);

		return $releases ? $releases[0] : false;
	}

	public function getReleasesByElggVersion($elgg_version) {
		$options = array(
			'type' => 'object',
			'subtype' => 'plugin_release',
			'container_guid' => $this->guid,
			'metadata_name_value_pairs' => array(
				'name' => 'elgg_version',
				'value' => $elgg_version
			),
			'limit' => false
		);

		return elgg_get_entities_from_metadata($options);
	}

	/**
	 * Get a list of releases associated with this project
	 * 
	 * @param array $options
	 * @return array
	 */
	public function getReleases(array $options) {
		return elgg_get_entities(array_merge($options, array(
			'type' => 'object',
			'subtype' => 'plugin_release',
			'container_guid' => $this->guid,
		)));
	}

	/**
	 * Increment the download count
	 */
	public function updateDownloadCount() {
		// increment total downloads for all plugins
		$count = (int) elgg_get_plugin_setting('site_plugins_downloads', 'community_plugins');
		elgg_set_plugin_setting('site_plugins_downloads', ++$count, 'community_plugins');

		// increment this plugin project's downloads
		$this->dbUpdateDownloadCount();
	}

	/**
	 * Get the download count for this plugin project
	 * @return int
	 */
	public function getDownloadCount() {
		return $this->dbGetDownloadCount();
	}

	public function saveImage($name, $title, $index) {

		if ($_FILES[$name]['error'] != 0) {
			return FALSE;
		}

		$info = $_FILES[$name];

		// delete original image if exists
		$options = array(
			'relationship_guid' => $this->getGUID(),
			'relationship' => 'image',
			'metadata_name_value_pair' => array('name' => 'project_image', 'value' => "$index")
		);
		if ($old_image = elgg_get_entities_from_relationship($options)) {
			if ($old_image[0] instanceof ElggFile) {
				$old_image[0]->delete();
			}
		}

		$image = new ElggFile();
		$prefix = "plugins/";
		$store_name_base = $prefix . strtolower($this->getGUID() . "_$name");
		$image->title = $title;
		$image->access_id = $this->access_id;
		$image->owner_guid = $this->guid;
		$image->setFilename($store_name_base . '.jpg');
		$image->setMimetype('image/jpeg');
		$image->originalfilename = $info['name'];
		$image->project_image = $index; // used for deletion on replacement
		$image->save();

		$uf = get_uploaded_file($name);
		if (!$uf) {
			return FALSE;
		}
		$image->open("write");
		$image->write($uf);
		$image->close();

		add_entity_relationship($this->guid, 'image', $image->guid);

		// create a thumbnail
		if ($this->saveThumbnail($image, $store_name_base . '_thumb.jpg') != TRUE) {
			$image->delete();
			return FALSE;
		}

		return TRUE;
	}

	protected function saveThumbnail($image, $name) {
		try {
			$thumbnail = get_resized_image_from_existing_file($image->getFilenameOnFilestore(), 60, 60, true);
		} catch (Exception $e) {
			return FALSE;
		}

		$thumb = new ElggFile();
		$thumb->setMimeType('image/jpeg');
		$thumb->access_id = $this->access_id;
		$thumb->owner_guid = $this->guid;
		$thumb->setFilename($name);
		$thumb->open("write");
		$thumb->write($thumbnail);
		$thumb->save();
		$image->thumbnail_guid = $thumb->getGUID();

		if (!$thumb->getGUID()) {
			$thumb->delete();
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Update the number of downloads
	 */
	protected function dbUpdateDownloadCount() {
		$guid = $this->getGUID();
		$db_prefix = get_config('dbprefix');
		$sql = "INSERT INTO {$db_prefix}plugin_downloads
			(guid, downloads) VALUES ($guid, 1)
			ON DUPLICATE KEY UPDATE downloads=downloads+1";
		insert_data($sql);
	}

	/**
	 * Get the number of downloads from the database
	 * 
	 * @return int
	 */
	protected function dbGetDownloadCount() {
		$guid = $this->getGUID();
		$db_prefix = get_config('dbprefix');
		$sql = "SELECT downloads FROM {$db_prefix}plugin_downloads
			WHERE guid = $guid";
		$result = get_data_row($sql);
		if ($result === false) {
			return 0;
		}
		return (int) $result->downloads;
	}

	/**
	 * Get the plugins downloaded the most
	 *
	 * @param array $options Options array for elgg_get_entities()
	 * @return array
	 */
	static public function getPluginsByDownloads(array $options = array()) {
		$db_prefix = get_config('dbprefix');

		$defaults = array(
			'type' => 'object',
			'subtype' => 'plugin_project',
			'joins' => array("JOIN {$db_prefix}plugin_downloads pd ON e.guid=pd.guid"),
			'order_by' => 'pd.downloads DESC',
		);
		$options = array_merge($defaults, $options);

		return elgg_get_entities($options);
	}

	/**
	 * Sync the titles of releases with the title of the project
	 */
	public function updateReleaseTitles() {
		$releases = $this->getReleases(array('limit' => false));

		foreach ($releases as $r) {
			$r->title = $this->title;
			$r->save();
		}
	}

	/*
	 * move the files on the file system to a new owner guid
	 * @param ElggFile $file - The file with resources to be moved
	 * @param int $new_owner_guid - new owner guid where the resources will be moved
	 */

	static public function moveFilesOnSystem($file, $new_owner_guid) {
		if (!($file instanceof ElggFile)) {
			return false;
		}

		if ($file->owner_guid == $new_owner_guid) {
			return true; // no need to move
		}

		$old_location = $file->getFileNameOnFilestore();

		$file->owner_guid = $new_owner_guid;

		$new_location = $file->getFileNameOnFilestore();

		$move = true;
		//make sure new location exists
		if (!is_dir(dirname($new_location))) {
			if (!@mkdir(dirname($new_location), 0700, true)) {
				$move = false;
			}
		}

		if (!$move || !rename($old_location, $new_location)) {
			error_log(elgg_echo('plugins:action:transfer:not_moved', array($file->guid)));
			return false;
		}

		// cleanup
		// note - rmdir only removes empty directories
		@rmdir(dirname($old_location));

		return true;
	}

	/**
	 * Set Github project details
	 *
	 * @param string $owner Repo owner
	 * @param string $repo  Repo name
	 * @return void
	 */
	public function setGithubRepo($owner, $repo) {
		if (empty($owner) || empty($repo)) {
			return;
		}
		$this->github_owner = $owner;
		$this->github_repo = $repo;
		if (!isset($this->github_secret)) {
			$this->github_secret = generate_random_cleartext_password();
		}
		if (empty($this->repo)) {
			$this->repo = "https://github.com/$this->github_owner/$this->github_repo";
		}
	}

	/**
	 * Create a new release from uploaded file
	 * 
	 * @param string $input_name         File input name
	 * @param array  $attrs              Attributes and metadata to set on the release
	 * @param bool   $create_river_entry Create river entry for the new release
	 * @return PluginRelease|false
	 */
	public function addReleaseFromUpload($input_name, array $attrs = [], $create_river_entry = false) {

		$files = _elgg_services()->request->files;
		if (!$files->has($input_name)) {
			return false;
		}

		$input = $files->get($input_name);
		if (!$input instanceof UploadedFile || !$input->isValid()) {
			return false;
		}

		$originalfilename = $input->getClientOriginalName();
		$release_filename = time() . $originalfilename;

		$release = new PluginRelease();
		$release->container_guid = $this->guid;
		$release->setFilename("plugins/$release_filename");
		$release->open('write');
		$release->close();

		copy($input->getPathname(), $release->getFilenameOnFilestore());

		if (!$release->getManifest()) {
			$release->delete();
			return false;
		}

		$release->title = $this->title;
		$release->mimetype = (new MimeTypeDetector())->getType($release_filename, $input->getClientMimeType());
		$release->simpletype = elgg_get_file_simple_type($release->mimetype);
		$release->originalfilename = $originalfilename;

		unlink($input->getPathname());

		foreach ($attrs as $key => $value) {
			switch ($key) {
				case 'recommended' :
					$release->setRecommended((array) $value);
					break;
				case 'release_notes' :
					$release->$key = \Elgg\CommunityPlugins\plugins_strip_tags($value);
					break;
				default :
					$release->$key = $value;
					break;
			}
		}

		if ($release->save()) {
			if ($create_river_entry) {
				$release->createRiverEntry();
			}
			update_entity_last_action($this->guid);
			return $release;
		}

		return false;
	}

	/**
	 * Create a new release from Github
	 *
	 * @param int   $github_release_id  Github release id
	 * @param array $attrs              Attributes and metadata to set on the release
	 * @param bool  $create_river_entry Create a river entry for the new release
	 * @return PluginRelease|false
	 */
	public function addReleaseFromGithub($github_release_id, array $attrs = [], $create_river_entry = false) {

		$ia = elgg_set_ignore_access(true);
		$existing = elgg_get_entities_from_metadata([
			'types' => 'object',
			'subtypes' => 'plugin_release',
			'metadata_name_value_pairs' => [
				'name' => 'github_guid',
				'value' => implode(':', [$this->github_owner, $this->github_repo, $github_release_id]),
			],
			'count' => true,
		]);
		elgg_set_ignore_access($ia);

		if ($existing) {
			return false;
		}

		$api = new GithubService();
		$release_data = $api->getRelease($this->github_owner, $this->github_repo, $github_release_id);

		if (empty($release_data)) {
			return false;
		}

		$download_url = false;
		$assets = $release_data['assets'];
		if (empty($assets)) {
			return false;
		}
		foreach ($assets as $asset) {
			if ($asset['content_type'] !== 'application/zip') {
				continue;
			}
			$download_url = $asset['browser_download_url'];
			$originalfilename = $asset['name'];
			break;
		}

		if (!$download_url) {
			return false;
		}

		if (!$originalfilename) {
			$originalfilename = pathinfo($download_url, PATHINFO_BASENAME);
		}

		$contents = (new HttpClient())->get($download_url);

		if (empty($contents)) {
			return false;
		}

		$release_filename = time() . $originalfilename;

		$owner_guid = elgg_extract('owner_guid', $attrs);
		unset($attrs['owner_guid']);
		if (!$owner_guid) {
			$owner_guid = elgg_is_logged_in() ? elgg_get_logged_in_user_entity() : $this->owner_guid;
		}
		$release = new PluginRelease();
		$release->owner_guid = $owner_guid;
		$release->container_guid = $this->guid;
		$release->setFilename("plugins/$release_filename");

		$release->open('write');
		$release->write($contents);
		$release->close();

		if (!$release->getManifest()) {
			$release->delete();
			return false;
		}

		$release->title = $this->title;
		$release->mimetype = 'application/zip';
		$release->simpletype = elgg_get_file_simple_type($release->mimetype);
		$release->originalfilename = $originalfilename;

		$github_attrs = [
			'release_notes' => $release_data['body'],
			'version' => $release_data['tag_name'],
			'github_owner' => $this->github_owner,
			'github_repo' => $this->github_repo,
			'access_id' => $this->github_access_id,
			'comments' => $this->github_comments,
			'github_id' => $release_data['id'],
			'github_guid' => implode(':', [$this->github_owner, $this->github_repo, $release_data['id']]),
			'github_tag_name' => $release_data['tag_name'],
			'github_draft' => $release_data['draft'],
			'github_prerelease' => $release_data['prerelease'], 'github_access_id  '
		];

		$attrs = array_merge($github_attrs, $attrs);

		foreach ($attrs as $key => $value) {
			switch ($key) {
				case 'recommended' :
					$release->setRecommended((array) $value);
					break;
				case 'release_notes' :
					$release->$key = \Elgg\CommunityPlugins\plugins_strip_tags($value);
					break;
				default :
					$release->$key = $value;
					break;
			}
		}

		if (empty($release->elgg_version)) {
			$release->elgg_version = $release->getSupportedElggVersions(false);
		}

		if (!isset($attrs['recommended']) && !$release->github_draft && !$release->github_prerelease) {
			$recommended = array();
			$elgg_versions = (array) $release->elgg_version;
			foreach ($elgg_versions as $elgg_version) {
				$recommended_releases = elgg_get_entities_from_metadata(array(
					'type' => 'object',
					'subtype' => 'plugin_release',
					'container_guid' => $this->guid,
					'metadata_name_value_pairs' => array(
						'name' => 'recommended',
						'value' => $elgg_version
					),
					'limit' => 1
				));

				$recommended_release = false;
				if ($recommended_releases) {
					$recommended_release = $recommended_releases[0]->version;
				}

				if (!$recommended_release || version_compare($release->version, $recommended_release, '>')) {
					$recommended[] = $elgg_version;
				}
			}
			$release->setRecommended($recommended);
		}

		// Allow event handlers to do more stuff with data
		$release->setVolatileData('github_release', $release_data);

		if ($release->save()) {
			if ($create_river_entry) {
				$release->createRiverEntry();
			}
			update_entity_last_action($this->guid);
			return $release;
		}

		return false;
	}

	/**
	 * Process Github webhook payload
	 * @return PluginRelease
	 * @throws \Elgg\CommunityPlugins\HttpException
	 */
	public function digestGithubPayload() {

		if (!$this->github_secret) {
			throw new \Elgg\CommunityPlugins\HttpException('Plugin project can not be released via Github', 400);
		}

		$api = new GithubService();
		$payload = $api->filterPayload($this->github_secret);

		$event = _elgg_services()->request->headers->get('X-GitHub-Event');
		$delivery = _elgg_services()->request->headers->get('X-Github-Delivery');

		switch ($event) {
			case 'release' :
				if ($payload['action'] != 'published' || !isset($payload['release'])) {
					throw new \Elgg\CommunityPlugins\HttpException('Unrecognized payload structure', 400);
				}
				$github_release_id = $payload['release']['id'];
				$release = $this->addReleaseFromGithub($github_release_id, [
					'owner_guid' => $this->owner_guid,
						], true);

				if (!$release) {
					throw new \Elgg\CommunityPlugins\HttpException("Unable to create new plugin project release for Github release $github_release_id", 400);
				}
				
				$release->github_delivery_id = $delivery;
				return $release;

			default :
				throw new  \Elgg\CommunityPlugins\HttpException("Payload for $event event can not be digested", 501);
		}
	}

}
