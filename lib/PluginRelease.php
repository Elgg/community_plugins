<?php

class PluginRelease extends ElggFile {
	protected function initialise_attributes() {
		parent::initialise_attributes();

		$this->attributes['subtype'] = "plugin_release";
	}

	public function __construct($guid = null) {
		parent::__construct($guid);
	}
}

