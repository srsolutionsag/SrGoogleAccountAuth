<?php

use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Authentication\AuthenticationFormGUI;
use srag\Plugins\SrGoogleAccountAuth\Authentication\AuthenticationProvider;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class ilSrGoogleAccountAuthUIHookGUI
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilSrGoogleAccountAuthUIHookGUI extends ilUIHookPluginGUI
{

    use DICTrait;
    use SrGoogleAccountAuthTrait;
    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    const LOGIN_TEMPLATE_ID = "Services/Init/tpl.login.html";
    const TEMPLATE_ADD = "template_add";
    /**
     * @var bool
     */
    protected static $auth_check = false;


    /**
     * @inheritDoc
     */
    public function getHTML(/*string*/ $a_comp, /*string*/ $a_part, /*array*/ $a_par = []) : array
    {
        if (!self::$auth_check && $a_par["tpl_id"] === self::LOGIN_TEMPLATE_ID && $a_part === self::TEMPLATE_ADD) {
            self::$auth_check = true;

            $this->checkAuthentication();

            $html = $a_par["html"];

            self::dic()->mainTemplate()->addCss(self::plugin()->directory() . "/css/srgoogacauth.css");

            $html = str_replace('<div class="ilStartupSection">', '<div class="ilStartupSection">' . self::output()->getHTML(new AuthenticationFormGUI($this)), $html);

            return ["mode" => self::REPLACE, "html" => $html];
        }

        return parent::getHTML($a_comp, $a_part, $a_par);
    }


    /**
     *
     */
    protected function checkAuthentication()/*: void*/
    {
        $target = filter_input(INPUT_GET, "target");

        $matches = [];
        preg_match("/^uihk_" . ilSrGoogleAccountAuthPlugin::PLUGIN_ID . "(_(.*))?/uim", $target, $matches);

        if (is_array($matches) && count($matches) >= 1) {

            $status = ilAuthStatus::getInstance();

            $credentials = new ilAuthFrontendCredentials();

            $provider = new AuthenticationProvider($credentials);

            $frontend = new ilAuthFrontend(self::dic()->authSession(), $status, $credentials, [
                $provider
            ]);

            $frontend->authenticate();

            switch ($status->getStatus()) {
                case ilAuthStatus::STATUS_AUTHENTICATED:
                    unset($_GET["target"]); // Fix redirecting not user defaults start page
                    ilInitialisation::redirectToStartingPage();

                    return;

                default:
                    ilUtil::sendFailure($status->getReason());
                    break;
            }
        }
    }
}
