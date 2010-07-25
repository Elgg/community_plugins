<?php

class PluginProject extends ElggObject {
	protected function initialise_attributes() {
		parent::initialise_attributes();

		$this->attributes['subtype'] = "plugin_project";
	}

	public function __construct($guid = null) {
		parent::__construct($guid);
	}
}
