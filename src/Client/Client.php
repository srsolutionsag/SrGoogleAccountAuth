<?php

namespace srag\Plugins\SrGoogleAccountAuth\Client;

use Closure;
use Google_Client;
use Google_Service_PeopleService;
use ilSession;
use ilSrGoogleAccountAuthPlugin;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Config\ConfigFormGUI;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class Client
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Client
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Client extends Google_Client
{

    use DICTrait;
    use SrGoogleAccountAuthTrait;

    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    const REDIRECT_URL = "login.php?target=uihk_" . ilSrGoogleAccountAuthPlugin::PLUGIN_ID;
    const SESSION_KEY = "google_access_token";
    const ICON_URL = "https://developers.google.com/identity/images/g-logo.png";
    const GOOGLE = "Google";
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Client constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->init();
    }


    /**
     *
     */
    protected function init()/*: void*/
    {
        $this->setApplicationName("Login to " . ilSrGoogleAccountAuthPlugin::PLUGIN_NAME);

        $this->setClientId(self::srGoogleAccountAuth()->config()->getValue(ConfigFormGUI::KEY_CLIENT_ID));
        $this->setClientSecret(self::srGoogleAccountAuth()->config()->getValue(ConfigFormGUI::KEY_CLIENT_SECRET));
        $this->setRedirectUri(ILIAS_HTTP_PATH . "/" . self::REDIRECT_URL);

        $access_token = ilSession::get(self::SESSION_KEY);
        if (!empty($access_token)) {
            $this->setAccessToken($access_token);
        }
        if ($this->isAccessTokenExpired()) {
            Closure::bind(function ()/*:void*/ {
                $this->token = null; // `setAccessToken(null)` can not be reset
            }, $this, Google_Client::class)();
        }

        $this->setScopes([
            Google_Service_PeopleService::USERINFO_PROFILE,
            Google_Service_PeopleService::USERINFO_EMAIL,
            Google_Service_PeopleService::USER_EMAILS_READ
        ]);

        $state = self::srGoogleAccountAuth()->authentication()->getState();
        if (!empty($state)) {
            $this->setState(strtr(base64_encode($state), "+/=", "-_,"));
        }
    }
}
