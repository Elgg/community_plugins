<?php

class PluginRelease extends ElggFile {
	protected function initialise_attributes() {
		parent::initialise_attributes();

		$this->attributes['subtype'] = "plugin_release";
	}

	public function __construct($guid = null) {
		parent::__construct($guid);
	}

	/**
	 * Get the plugin project for this release
	 * @return PluginProject
	 */
	public function getProject() {
		return get_entity($this->container_guid);
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
	 * Sets the hash that is used to uniquely identify this plugin
	 */
	public function setHash() {
		$archiveName = $this->getFilenameOnFilestore();

		$zip = new ZipArchive();
		$result = $zip->open($archiveName);
		if ($result !== true) {
			return false;
		}

		for ($i=0; $i<$zip->numFiles; $i++) {
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
