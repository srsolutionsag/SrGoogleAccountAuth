<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\DIC\SrGoogleAccountAuth\DICTrait;
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

    const LOGIN_TEMPLATE_ID = "Services/Init/tpl.login.html";
    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    const TEMPLATE_ADD = "template_add";
    /**
     * @var bool
     */
    protected static $auth_check = false;
    /**
     * @var bool
     */
    protected static $render_auth_form = false;


    /**
     * @inheritDoc
     */
    public function getHTML(/*string*/ $a_comp, /*string*/ $a_part, /*array*/ $a_par = []) : array
    {
        if (!self::$auth_check) {
            self::$auth_check = true;

            $this->checkAuthentication();
        }

        if (!self::$render_auth_form && $a_par["tpl_id"] === self::LOGIN_TEMPLATE_ID && $a_part === self::TEMPLATE_ADD) {
            self::$render_auth_form = true;

            $html = $a_par["html"];

            self::dic()->ui()->mainTemplate()->addCss(self::plugin()->directory() . "/css/srgoogacauth.css");

            $html = str_replace('<div class="ilStartupSection">',
                '<div class="ilStartupSection">' . self::output()->getHTML(self::srGoogleAccountAuth()->authentication()->factory()->newFormBuilderInstance($this)), $html);

            return ["mode" => self::REPLACE, "html" => $html];
        }

        return parent::getHTML($a_comp, $a_part, $a_par);
    }


    /**
     *
     */
    protected function checkAuthentication()/*: void*/
    {
        if (basename(filter_input(INPUT_SERVER, "SCRIPT_NAME")) === "login.php") {
            $matches = [];
            preg_match("/^uihk_" . ilSrGoogleAccountAuthPlugin::PLUGIN_ID . "(_(.*))?/uim", self::srGoogleAccountAuth()->authentication()->getTarget(), $matches);

            if (is_array($matches) && count($matches) >= 1) {

                $status = ilAuthStatus::getInstance();

                $credentials = new ilAuthFrontendCredentials();

                $provider = self::srGoogleAccountAuth()->authentication()->factory()->newProviderInstance($credentials);

                $frontend = new ilAuthFrontend(self::dic()->authSession(), $status, $credentials, [
                    $provider
                ]);

                $frontend->authenticate();

                switch ($status->getStatus()) {
                    case ilAuthStatus::STATUS_AUTHENTICATED:
                        $_GET["target"] = self::srGoogleAccountAuth()->authentication()->getState(false);

                        ilInitialisation::redirectToStartingPage();

                        return;

                    default:
                        ilUtil::sendFailure($status->getReason());
                        break;
                }
            }
        }
    }
}
