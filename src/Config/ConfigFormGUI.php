<?php

namespace srag\Plugins\SrGoogleAccountAuth\Config;

use ilSrGoogleAccountAuthPlugin;
use ilTextInputGUI;
use srag\ActiveRecordConfig\SrGoogleAccountAuth\ActiveRecordConfigFormGUI;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class ConfigFormGUI
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends ActiveRecordConfigFormGUI {

	use SrGoogleAccountAuthTrait;
	const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
	const CONFIG_CLASS_NAME = Config::class;


	/**
	 * @inheritdoc
	 */
	protected function initFields()/*: void*/ {
		$this->fields = [
			Config::KEY_CLIENT_ID => [
				self::PROPERTY_CLASS => ilTextInputGUI::class,
				self::PROPERTY_REQUIRED => true
			],
			Config::KEY_CLIENT_SECRET => [
				self::PROPERTY_CLASS => ilTextInputGUI::class,
				self::PROPERTY_REQUIRED => true
			]
		];
	}
}
