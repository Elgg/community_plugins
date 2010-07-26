<?php

class PluginRelease extends ElggFile {
	protected function initialise_attributes() {
		parent::initialise_attributes();

		$this->attributes['subtype'] = "plugin_release";
	}

	public function __construct($guid = null) {
		parent::__construct($guid);
	}

	public function incrementDownloadCount() {
		create_annotation($this->guid, 'download', 1, 'integer', 0, ACCESS_PUBLIC);
	}

	public function savePluginFile($name) {
		$uf = get_uploaded_file($name);
		if (!$uf) {
			return FALSE;
		}
		$this->open("write");
		$this->write($uf);
		$this->close();

		return TRUE;
	}

}

