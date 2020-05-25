<?php

namespace srag\Plugins\SrGoogleAccountAuth\Authentication\Form;

use ilSrGoogleAccountAuthPlugin;
use ilSrGoogleAccountAuthUIHookGUI;
use srag\CustomInputGUIs\SrGoogleAccountAuth\FormBuilder\AbstractFormBuilder;
use srag\Plugins\SrGoogleAccountAuth\Client\Client;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class FormBuilder
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Authentication\Form
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class FormBuilder extends AbstractFormBuilder
{

    use SrGoogleAccountAuthTrait;

    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;


    /**
     * @inheritDoc
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
    protected function getAction() : string
    {
        return "";
    }


    /**
     * @inheritDoc
     */
    protected function getButtons() : array
    {
        $buttons = [];

        return $buttons;
    }


    /**
     * @inheritDoc
     */
    protected function getData() : array
    {
        $data = [];

        return $data;
    }


    /**
     * @inheritDoc
     */
    protected function getFields() : array
    {
        $fields = [];

        return $fields;
    }


    /**
     * @inheritDoc
     */
    protected function getTitle() : string
    {
        return self::plugin()->translate("login_with", "", [Client::GOOGLE]);
    }


    /**
     * @inheritDoc
     */
    protected function setButtonsToForm(string $html) : string
    {
        $first = true;

        $html = preg_replace_callback(self::REPLACE_BUTTONS_REG_EXP, function (array $matches) use (&$first) : string {
            if ($first) {
                $first = false;

                $authentication_button_tpl = self::plugin()->template("authentication_button.html");
                $authentication_button_tpl->setVariable("LINK", self::srGoogleAccountAuth()->client()->createAuthUrl());
                $authentication_button_tpl->setVariable("IMG", self::output()->getHTML(self::dic()->ui()->factory()->image()->standard(Client::ICON_URL, Client::GOOGLE)));
                $authentication_button_tpl->setVariableEscaped("TXT", self::dic()->language()->txt("log_in"));

                return self::output()->getHTML($authentication_button_tpl);
            } else {
                return "";
            }
        }, $html);

        return $html;
    }


    /**
     * @inheritDoc
     */
    protected function storeData(array $data)/* : void*/
    {

    }
}
