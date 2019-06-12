<?php

namespace srag\Plugins\SrGoogleAccountAuth\Provider;

use Google_Client;
use Google_Service_PeopleService;
use ilAuthCredentials;
use ilAuthProviderInterface;
use ilAuthStatus;
use ilSession;
use ilSrGoogleAccountAuthPlugin;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Config\Config;
use srag\Plugins\SrGoogleAccountAuth\Exception\SrGoogleAccountAuthException;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;
use Throwable;

/**
 * Class AuthProvider
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Provider
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class AuthProvider implements ilAuthProviderInterface {

	use DICTrait;
	use SrGoogleAccountAuthTrait;
	const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
	const AUTH_NAME = "authhk_" . ilSrGoogleAccountAuthPlugin::PLUGIN_ID . "_auth_name";
	const AUTH_ID = 1234;
	const REDIRECT_URL =  "Customizing/global/plugins/Services/Authentication/AuthenticationHook/SrGoogleAccountAuth/google_login.php";
	const SESSION_KEY = "google_access_token";


	/**
	 * @return Google_Client
	 */
	public static function getClient(): Google_Client {
		$client = new Google_Client();

		$client->setApplicationName("Login to " . ilSrGoogleAccountAuthPlugin::PLUGIN_NAME);

		$client->setClientId(Config::getField(Config::KEY_CLIENT_ID));
		$client->setClientSecret(Config::getField(Config::KEY_CLIENT_SECRET));
		$client->setRedirectUri(ILIAS_HTTP_PATH . "/" . self::REDIRECT_URL);

		$access_token = ilSession::get(self::SESSION_KEY);
		if (!empty($access_token)) {
			$client->setAccessToken($access_token);
		}

		$client->setScopes([
			Google_Service_PeopleService::USERINFO_PROFILE,
			Google_Service_PeopleService::USERINFO_EMAIL,
			Google_Service_PeopleService::USER_EMAILS_READ
		]);

		return $client;
	}


	/**
	 * @var ilAuthCredentials
	 */
	protected $credentials;


	/**
	 * AuthProvider constructor
	 *
	 * @param ilAuthCredentials $credentials
	 */
	public function __construct(ilAuthCredentials $credentials) {
		$this->credentials = $credentials;
	}


	/**
	 * @inheritdoc
	 */
	public function doAuthentication(ilAuthStatus $status): bool {
		try {
			$client = self::getClient();

			if (empty($client->getAccessToken())) {

				$code = filter_input(INPUT_GET, "code");
				if (empty($code)) {
					throw new SrGoogleAccountAuthException("No code set!");
				}

				$client->fetchAccessTokenWithAuthCode($code);

				$access_token = $client->getAccessToken();
				if (empty($access_token)) {
					throw new SrGoogleAccountAuthException("No access token set!");
				}

				ilSession::set(self::SESSION_KEY, $access_token);
			}

			if ($client->isAccessTokenExpired()) {
				throw new SrGoogleAccountAuthException("Access token expired!");
			}

			$service = new Google_Service_PeopleService($client);

			$email = current($service->people->get("people/me", [
				"personFields" => "emailAddresses"
			])->getEmailAddresses())->getValue();
			if (empty($email)) {
				throw new SrGoogleAccountAuthException("Email address not found!");
			}

			$user_id = self::ilias()->users()->getUserIdByEmail($email);
			if (empty($user_id)) {
				throw new SrGoogleAccountAuthException("No ILIAS user found!");
			}

			$status->setStatus(ilAuthStatus::STATUS_AUTHENTICATED);

			$status->setAuthenticatedUserId($user_id);

			return true;
		} catch (Throwable $ex) {
			$status->setStatus(ilAuthStatus::STATUS_AUTHENTICATION_FAILED);

			$status->setReason($ex->getMessage());

			return false;
		}
	}
}
