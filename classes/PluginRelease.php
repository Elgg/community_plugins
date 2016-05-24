<?php

/**
 * Plugin Release
 *
 * @property string[] $elgg_version       Supported Elgg version(s)
 * @property string[] $recommended        Elgg version(s) this release is recommended for
 * @property string   $manifest           Contents of the manifest.xml
 * @property string   $hash               MD5 hash used to uniquely identify this release
 * @property string   $github_owner       Owner of the github repository
 * @property string   $github_repo        Name of the github repository
 * @property int      $github_id          ID of the github release
 * @property string   $github_tag_name    Tag associated with the release
 * @property bool     $github_draft       Is marked as Draft on Github
 * @property bool     $github_prereleases Is marked as Pre-release on Github
 */
class PluginRelease extends ElggFile {

	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "plugin_release";
	}

	/**
	 * Get the plugin project for this release
	 * @return PluginProject
	 */
	public function getProject() {
		return $this->getContainerEntity();
	}

	public function isRecommendedRelease($elgg_version) {
		$recommended = (array) $this->recommended;

		return in_array($elgg_version, $recommended);
	}

	public function updateDownloadCount() {
		create_annotation($this->guid, 'download', 1, 'integer', 0, ACCESS_PUBLIC);
	}

	public function saveArchive($name) {
		$uf = get_uploaded_file($name);
		if (!$uf) {
			return FALSE;
		}
		$this->open("write");
		$this->write($uf);
		$this->close();

		return true;
	}

	/**
	 * 
	 * @param array $recommended - an array of elgg versions this release is recommended for
	 */
	public function setRecommended($recommended) {
		$project = $this->getProject();

		$recommended = (array) $recommended;

		// update recommended if required
		if ($recommended) {
			$saved_r = array(); // the actual value saved - we don't set recommended on unless elgg_version is set
			foreach ($recommended as $ev) {
				if (!in_array($ev, (array) $this->elgg_version)) {
					continue;
				}

				$saved_r[] = $ev;

				// remove recommended for this elgg version from other releases
				$existing_releases = $project->getReleasesByElggVersion($ev);
				if ($existing_releases) {
					foreach ($existing_releases as $r) {
						$r_recommended = (array) $r->recommended;
						if (($key = array_search($ev, $r_recommended)) !== false) {
							unset($r_recommended[$key]);
						}
						$r->recommended = $r_recommended;
					}
				}
			}

			$this->recommended = $saved_r;
		} else {
			$this->recommended = array();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function save() {
		if (!isset($this->hash)) {
			$this->setHash();
		}
		return parent::save();
	}

	/**
	 * Sets the hash that is used to uniquely identify this plugin
	 * @return void
	 */
	public function setHash() {

		$manifest = $this->getManifest();
		if (!$manifest) {
			return;
		}

		$id = $manifest->getPluginId();
		$author = $manifest->getAuthor();
		$version = $manifest->getVersion();

		$this->hash = md5($id . $version . $author);
	}

	/**
	 * Reads manifest.xml from release archive
	 * @return ElggPluginManifest|false
	 */
	public function getManifest() {
		$zip = new ZipArchive();
		$result = $zip->open($this->getFilenameOnFilestore());
		if ($result !== true) {
			return false;
		}

		for ($i = 0; $i < $zip->numFiles; $i++) {
			$filename = $zip->getNameIndex($i);
			if (stripos($filename, 'manifest.xml') !== false) {
				$manifest = $zip->getFromIndex($i);
				$id = basename(dirname($filename));
				try {
					// make sure we have a valid manifest.xml
					$plugin_manifest = new ElggPluginManifest($manifest, $id);
				} catch (Exception $ex) {

				}
				if (isset($plugin_manifest)) {
					break;
				}
			}
		}

		$zip->close();

		if (!isset($plugin_manifest)) {
			return false;
		}

		return $plugin_manifest;
	}

	/**
	 * Get Elgg versions supported by this release
	 *
	 * @param bool $use_cache Use cached values, if any
	 * @return array
	 */
	public function getSupportedElggVersions($use_cache = true) {
		if ($use_cache && $this->elgg_version) {
			return (array) $this->elgg_version;
		}

		$manifest = $this->getManifest();
		if (!$manifest) {
			return [];
		}

		$elgg_versions = elgg_get_config('elgg_versions');
		$supported_versions = [];
		$requires = $manifest->getRequires();
		foreach ($requires as $key => $require) {
			if ($require['type'] != 'elgg_release') {
				unset($requires[$key]);
			}
		}

		foreach ($elgg_versions as $elgg_version) {
			$supported = true;
			foreach ($requires as $require) {
				$this_version = $require['version'];
				if (!version_compare($elgg_version, $this_version, $require['comparison'])) {
					$supported = false;
				}
			}
			if ($supported) {
				$supported_versions[] = $elgg_version;
			}
		}

		return $supported_versions;
	}

	/**
	 * Create river entry
	 * @return int|false
	 */
	public function createRiverEntry() {
		if (!$this->guid) {
			return false;
		}
		return elgg_create_river_item(array(
			'view' => 'river/object/plugin_release/create',
			'action_type' => 'create',
			'subject_guid' => (elgg_is_logged_in()) ? elgg_get_logged_in_user_guid() : $this->owner_guid,
			'object_guid' => $this->guid,
		));
	}

}
