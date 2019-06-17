<?php

namespace srag\Plugins\SrGoogleAccountAuth\Config;

use ilCheckboxInputGUI;
use ilMultiSelectInputGUI;
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
	protected function getValue(/*string*/ $key) {
		switch (true) {
			default:
				return parent::getValue($key);
		}
	}


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
			],
			Config::KEY_CREATE_NEW_ACCOUNTS => [
				self::PROPERTY_CLASS => ilCheckboxInputGUI::class,
				self::PROPERTY_SUBITEMS => [
					Config::KEY_NEW_ACCOUNT_ROLES => [
						self::PROPERTY_CLASS => ilMultiSelectInputGUI::class,
						self::PROPERTY_REQUIRED => true,
						self::PROPERTY_OPTIONS => self::ilias()->roles()->getAllRoles(),
						"enableSelectAll" => true
					],
				]
			],
		];
	}


	/**
	 * @inheritdoc
	 */
	protected function storeValue(/*string*/ $key, $value)/*: void*/ {
		switch ($key) {
			case Config::KEY_NEW_ACCOUNT_ROLES:
				if ($value[0] === "") {
					array_shift($value);
				}

				$value = array_map(function (string $role_id): int {
					return intval($role_id);
				}, $value);
				break;

			default:
				break;
		}

		parent::storeValue($key, $value);
	}
}
