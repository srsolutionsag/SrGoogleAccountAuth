<?php

namespace srag\Plugins\SrGoogleAccountAuth\Authentication;

use ilSrGoogleAccountAuthPlugin;
use ilSrGoogleAccountAuthUIHookGUI;
use srag\CustomInputGUIs\SrGoogleAccountAuth\PropertyFormGUI\PropertyFormGUI;
use srag\Plugins\SrGoogleAccountAuth\Client\Client;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class AuthenticationFormGUI
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Authentication
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class AuthenticationFormGUI extends PropertyFormGUI
{

    use SrGoogleAccountAuthTrait;
    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    const LANG_MODULE = "";


    /**
     * AuthenticationFormGUI constructor
     *
     * @param ilSrGoogleAccountAuthUIHookGUI $parent
     */
    public function __construct(ilSrGoogleAccountAuthUIHookGUI $parent)
    {
        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function getValue(/*string*/ $key)
    {
        switch ($key) {
            default:
                return null;
        }
    }


    /**
     * @inheritDoc
     */
    public function getHTML() : string
    {
        $html = parent::getHTML();

        $authentication_button_tpl = self::plugin()->template("authentication_button.html");
        $authentication_button_tpl->setVariable("LINK", self::srGoogleAccountAuth()->client()->createAuthUrl());
        $authentication_button_tpl->setVariable("IMG", self::output()->getHTML(self::dic()->ui()->factory()->image()->standard(Client::ICON_URL,Client::GOOGLE)));
        $authentication_button_tpl->setVariable("TXT", self::dic()->language()->txt("log_in"));

        $html = preg_replace('/<input\s+class="btn btn-default btn-sm"\s+type="submit"\s+name="cmd\[\]"\s+value=""\s*\/>/', self::output()->getHTML($authentication_button_tpl), $html);

        return $html;
    }


    /**
     * @inheritDoc
     */
    protected function initAction()/*: void*/
    {
        $this->setPreventDoubleSubmission(false);

        $this->setFormAction("");
    }


    /**
     * @inheritDoc
     */
    protected function initCommands()/*: void*/
    {
        $this->addCommandButton("", "");
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*: void*/
    {
        $this->fields = [];
    }


    /**
     * @inheritDoc
     */
    protected function initId()/*: void*/
    {

    }


    /**
     * @inheritDoc
     */
    protected function initTitle()/*: void*/
    {
        $this->setTitle(self::plugin()->translate("login_with", self::LANG_MODULE, [Client::GOOGLE]));
    }


    /**
     * @inheritDoc
     */
    protected function storeValue(/*string*/ $key, $value)/*: void*/
    {
        switch ($key) {
            default:
                break;
        }
    }
}
