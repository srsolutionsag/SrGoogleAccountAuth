<?php

namespace srag\Plugins\SrGoogleAccountAuth\Config;

use ilSrGoogleAccountAuthPlugin;
use srag\ActiveRecordConfig\SrGoogleAccountAuth\ActiveRecordConfig;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class Config
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Config extends ActiveRecordConfig {

	use SrGoogleAccountAuthTrait;
	const TABLE_NAME = "srgoogacauth_config";
	const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
	const KEY_CLIENT_ID = "client_id";
	const KEY_CLIENT_SECRET = "client_secret";
	/**
	 * @var array
	 */
	protected static $fields = [
		self::KEY_CLIENT_ID => self::TYPE_STRING,
		self::KEY_CLIENT_SECRET => self::TYPE_STRING
	];
}
