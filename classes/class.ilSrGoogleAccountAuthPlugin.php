<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\DIC\SrGoogleAccountAuth\Util\LibraryLanguageInstaller;
use srag\Plugins\SrGoogleAccountAuth\Config\Config;
use srag\Plugins\SrGoogleAccountAuth\Provider\AuthProvider;
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
	const PLUGIN_ID = "srgoogacauth";
	const PLUGIN_NAME = "SrGoogleAccountAuth";
	const PLUGIN_CLASS_NAME = self::class;
	const REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME = SrGoogleAccountAuthRemoveDataConfirm::class;
	const AUTH_NAME = "authhk_" . self::PLUGIN_ID . "_auth_name";
	const AUTH_ID = 1234;
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
	public function getAuthIdByName(/*string*/ $a_auth_name): int {
		switch ($a_auth_name) {
			case self::AUTH_NAME:
				return self::AUTH_ID;

			default:
				return 0;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getAuthIds(): array {
		return [ self::AUTH_ID ];
	}


	/**
	 * @inheritdoc
	 */
	public function getAuthName(/*int*/ $a_auth_id): string {
		switch ($a_auth_id) {
			case self::AUTH_ID:
				return self::AUTH_NAME;

			default:
				return "";
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getProvider(/*ilAuthCredentials*/ $credentials, /*string*/ $a_auth_name)/*:?ilAuthProviderInterface*/ {
		switch ($a_auth_name) {
			case self::AUTH_NAME:
				return new AuthProvider($credentials);

			default:
				return null;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function isAuthActive(/*int*/ $a_auth_id): bool {
		switch ($a_auth_id) {
			case self::AUTH_ID:
				return $this->isActive();

			default:
				return false;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function isExternalAccountNameRequired(/*int*/ $a_auth_id): bool {
		switch ($a_auth_id) {
			case self::AUTH_ID:
			default:
				return false;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function isPasswordModificationAllowed(/*int*/ $a_auth_id): bool {
		switch ($a_auth_id) {
			case self::AUTH_ID:
			default:
				return false;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getLocalPasswordValidationType(/*int*/ $a_auth_id): int {
		switch ($a_auth_id) {
			case self::AUTH_ID:
			default:
				return ilAuthUtils::LOCAL_PWV_FULL;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getMultipleAuthModeOptions(/*int*/ $a_auth_id): array {
		switch ($a_auth_id) {
			case self::AUTH_ID:
			default:
				return [];
		}
	}


	/**
	 * @inheritdoc
	 */
	public function supportsMultiCheck(/*int*/ $a_auth_id): bool {
		switch ($a_auth_id) {
			case self::AUTH_ID:
			default:
				return false;
		}
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
