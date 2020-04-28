<?php

namespace srag\Plugins\SrGoogleAccountAuth\Authentication;

use Google_Service_PeopleService;
use Google_Service_PeopleService_Gender;
use Google_Service_PeopleService_Name;
use ilAuthCredentials;
use ilAuthProvider;
use ilAuthProviderInterface;
use ilAuthStatus;
use ilSession;
use ilSrGoogleAccountAuthPlugin;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Client\Client;
use srag\Plugins\SrGoogleAccountAuth\Config\ConfigFormGUI;
use srag\Plugins\SrGoogleAccountAuth\Exception\SrGoogleAccountAuthException;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;
use Throwable;

/**
 * Class AuthenticationProvider
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Authentication
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class AuthenticationProvider extends ilAuthProvider implements ilAuthProviderInterface
{

    use DICTrait;
    use SrGoogleAccountAuthTrait;

    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;


    /**
     * AuthenticationProvider constructor
     *
     * @param ilAuthCredentials $credentials
     */
    public function __construct(ilAuthCredentials $credentials)
    {
        parent::__construct($credentials);
    }


    /**
     * @inheritDoc
     */
    public function doAuthentication(ilAuthStatus $status) : bool
    {
        try {
            if (empty(self::srGoogleAccountAuth()->client()->getAccessToken())) {

                $code = filter_input(INPUT_GET, "code");
                if (empty($code)) {
                    throw new SrGoogleAccountAuthException("No code set!");
                }

                self::srGoogleAccountAuth()->client()->fetchAccessTokenWithAuthCode($code);

                $access_token = self::srGoogleAccountAuth()->client()->getAccessToken();
                if (empty($access_token)) {
                    throw new SrGoogleAccountAuthException("No access token set!");
                }

                ilSession::set(Client::SESSION_KEY, $access_token);
            }

            if (self::srGoogleAccountAuth()->client()->isAccessTokenExpired()) {
                throw new SrGoogleAccountAuthException("Access token expired!");
            }

            $service = new Google_Service_PeopleService(self::srGoogleAccountAuth()->client());

            $result = $service->people->get("people/me", [
                "personFields" => ["names", "genders", "emailAddresses"]
            ]);

            $ext_id = $result->getResourceName();

            $email = current($result->getEmailAddresses())->getValue();

            $user_id = self::srGoogleAccountAuth()->ilias()->users()->getUserIdByExternalAccount($ext_id);

            if (empty($user_id)) {
                $user_id = self::srGoogleAccountAuth()->ilias()->users()->getUserIdByEmail($email);
            }

            if (empty($user_id)) {

                if (!self::srGoogleAccountAuth()->config()->getValue(ConfigFormGUI::KEY_CREATE_NEW_ACCOUNTS)) {
                    throw new SrGoogleAccountAuthException("No ILIAS user found for " . $ext_id . "/" . $email . "!");
                }

                $login = $email;

                /**
                 * @var Google_Service_PeopleService_Gender $genders
                 */
                $genders = current($result->getGenders());
                if (!empty($gender)) {
                    $gender = $genders->getValue();
                } else {
                    $gender = "";
                }

                /**
                 * @var Google_Service_PeopleService_Name $names
                 */
                $names = current($result->getNames());
                if (!empty($names)) {
                    $first_name = $names->getGivenName();
                    $last_name = $names->getFamilyName();
                } else {
                    $first_name = "";
                    $last_name = "";
                }

                $user_id = self::srGoogleAccountAuth()->ilias()->users()
                    ->createNewAccount($login, $email, $gender, $first_name, $last_name, $ext_id, self::srGoogleAccountAuth()->config()->getValue(ConfigFormGUI::KEY_NEW_ACCOUNT_ROLES));
            } else {
                self::srGoogleAccountAuth()->ilias()->users()->updateExtId($user_id, $ext_id);
            }

            $status->setAuthenticatedUserId($user_id);

            $status->setStatus(ilAuthStatus::STATUS_AUTHENTICATED);

            return true;
        } catch (Throwable $ex) {
            $this->getLogger()->log($ex->__toString());

            return $this->handleAuthenticationFail($status, self::plugin()->translate("login_failed", "", [Client::GOOGLE]));
        }
    }
}
