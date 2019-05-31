<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\DIC\SrGoogleAccountAuth\Util\LibraryLanguageInstaller;
use srag\Plugins\SrGoogleAccountAuth\Config\Config;
use srag\Plugins\SrGoogleAccountAuth\Provider\AuthDefinitionTrait;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;
use srag\RemovePluginDataConfirm\SrGoogleAccountAuth\PluginUninstallTrait;

/**
 * Class ilSrGoogleAccountAuthPlugin
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilSrGoogleAccountAuthPlugin extends ilAuthPlugin {

	use PluginUninstallTrait;
	use SrGoogleAccountAuthTrait;
	use AuthDefinitionTrait;
	const PLUGIN_ID = "srgoogacauth";
	const PLUGIN_NAME = "SrGoogleAccountAuth";
	const PLUGIN_CLASS_NAME = self::class;
	const REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME = SrGoogleAccountAuthRemoveDataConfirm::class;
	/**
	 * @var self|null
	 */
	protected static $instance = null;


	/**
	 * @return self
	 */
	public static function getInstance(): self {
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * ilSrGoogleAccountAuthPlugin constructor
	 */
	public function __construct() {
		parent::__construct();
	}


	/**
	 * @return string
	 */
	public function getPluginName(): string {
		return self::PLUGIN_NAME;
	}


	/**
	 * @inheritdoc
	 */
	public function updateLanguages($a_lang_keys = null) {
		parent::updateLanguages($a_lang_keys);

		LibraryLanguageInstaller::getInstance()->withPlugin(self::plugin())->withLibraryLanguageDirectory(__DIR__
			. "/../vendor/srag/removeplugindataconfirm/lang")->updateLanguages();
	}


	/**
	 * @inheritdoc
	 */
	protected function deleteData()/*: void*/ {
		self::dic()->database()->dropTable(Config::TABLE_NAME, false);
	}
}
