<?php

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
		return get_entity($this->container_guid);
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
		}
		else {
			$this->recommended = array();
		}
	}

	/**
	 * Sets the hash that is used to uniquely identify this plugin
	 */
	public function setHash() {
		$archiveName = $this->getFilenameOnFilestore();

		$zip = new ZipArchive();
		$result = $zip->open($archiveName);
		if ($result !== true) {
			return false;
		}

		for ($i = 0; $i < $zip->numFiles; $i++) {
			$filename = $zip->getNameIndex($i);
			if (stripos($filename, 'manifest.xml') !== false) {
				$manifest = $zip->getFromIndex($i);
				$id = substr($filename, 0, strpos($filename, '/'));
				break;
			}
		}

		$zip->close();

		if (!isset($manifest)) {
			return false;
		}

		try {
			$manifest = new ElggPluginManifest($manifest);
			$author = $manifest->getAuthor();
			$version = $manifest->getVersion();

			$this->hash = md5($id . $version . $author);
		} catch (Exception $e) {
			// skip invalid manifests
		}
	}

}
