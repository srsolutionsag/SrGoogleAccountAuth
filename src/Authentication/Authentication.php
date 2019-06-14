<?php

namespace srag\Plugins\SrGoogleAccountAuth\Authentication;

use Google_Service_PeopleService;
use ilInitialisation;
use ilSession;
use ilSrGoogleAccountAuthPlugin;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Client\Client;
use srag\Plugins\SrGoogleAccountAuth\Exception\SrGoogleAccountAuthException;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class Authentication
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Authentication
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Authentication {

	use DICTrait;
	use SrGoogleAccountAuthTrait;
	const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
	/**
	 * @var self
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
	 * Authentication constructor
	 */
	private function __construct() {

	}


	/**
	 * @throws SrGoogleAccountAuthException
	 */
	public function doAuthentication()/*: void*/ {
		if (empty(self::client()->getAccessToken())) {

			$code = filter_input(INPUT_GET, "code");
			if (empty($code)) {
				throw new SrGoogleAccountAuthException("No code set!");
			}

			self::client()->fetchAccessTokenWithAuthCode($code);

			$access_token = self::client()->getAccessToken();
			if (empty($access_token)) {
				throw new SrGoogleAccountAuthException("No access token set!");
			}

			ilSession::set(Client::SESSION_KEY, $access_token);
		}

		if (self::client()->isAccessTokenExpired()) {
			throw new SrGoogleAccountAuthException("Access token expired!");
		}

		$service = new Google_Service_PeopleService(self::client());

		$email = current($service->people->get("people/me", [
			"personFields" => "emailAddresses"
		])->getEmailAddresses())->getValue();
		if (empty($email)) {
			throw new SrGoogleAccountAuthException("User email address not found in ILIAS!");
		}

		$user_id = self::ilias()->users()->getUserIdByEmail($email);
		if (empty($user_id)) {
			throw new SrGoogleAccountAuthException("No ILIAS user found!");
		}

		self::dic()->authSession()->setAuthenticated(true, $user_id);

		ilInitialisation::redirectToStartingPage();
	}
}
