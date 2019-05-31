<?php

namespace srag\Plugins\SrGoogleAccountAuth\Provider;

use ilAuthUtils;

/**
 * Trait AuthDefinitionTrait
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Provider
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait AuthDefinitionTrait {

	/**
	 * @inheritdoc
	 */
	public function getAuthIdByName(/*string*/ $a_auth_name): int {
		switch ($a_auth_name) {
			case AuthProvider::AUTH_NAME:
				return AuthProvider::AUTH_ID;

			default:
				return 0;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getAuthIds(): array {
		return [ AuthProvider::AUTH_ID ];
	}


	/**
	 * @inheritdoc
	 */
	public function getAuthName(/*int*/ $a_auth_id): string {
		switch ($a_auth_id) {
			case AuthProvider::AUTH_ID:
				return AuthProvider::AUTH_NAME;

			default:
				return "";
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getProvider(/*ilAuthCredentials*/ $credentials, /*string*/ $a_auth_name)/*:?ilAuthProviderInterface*/ {
		switch ($a_auth_name) {
			case AuthProvider::AUTH_NAME:
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
			case AuthProvider::AUTH_ID:
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
			case AuthProvider::AUTH_ID:
			default:
				return false;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function isPasswordModificationAllowed(/*int*/ $a_auth_id): bool {
		switch ($a_auth_id) {
			case AuthProvider::AUTH_ID:
			default:
				return false;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getLocalPasswordValidationType(/*int*/ $a_auth_id): int {
		switch ($a_auth_id) {
			case AuthProvider::AUTH_ID:
				return ilAuthUtils::LOCAL_PWV_NO;

			default:
				return ilAuthUtils::LOCAL_PWV_FULL;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getMultipleAuthModeOptions(/*int*/ $a_auth_id): array {
		$client = AuthProvider::getClient();

		switch ($a_auth_id) {
			case AuthProvider::AUTH_ID:
				return [
					AuthProvider::AUTH_NAME => [
						"txt" => self::output()->getHTML(self::dic()->ui()->factory()->link()->standard(self::plugin()
							->translate("login"), $client->createAuthUrl()))
					]
				];

			default:
				return [];
		}
	}


	/**
	 * @inheritdoc
	 */
	public function supportsMultiCheck(/*int*/ $a_auth_id): bool {
		switch ($a_auth_id) {
			case AuthProvider::AUTH_ID:
			default:
				return false;
		}
	}
}
