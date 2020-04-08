<?php

namespace srag\Plugins\SrGoogleAccountAuth\Config;

use ilCheckboxInputGUI;
use ilSrGoogleAccountAuthPlugin;
use ilTextInputGUI;
use srag\CustomInputGUIs\SrGoogleAccountAuth\MultiSelectSearchNewInputGUI\MultiSelectSearchNewInputGUI;
use srag\CustomInputGUIs\SrGoogleAccountAuth\PropertyFormGUI\PropertyFormGUI;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class ConfigFormGUI
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends PropertyFormGUI
{

    use SrGoogleAccountAuthTrait;
    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    const KEY_CLIENT_ID = "client_id";
    const KEY_CLIENT_SECRET = "client_secret";
    const KEY_CREATE_NEW_ACCOUNTS = "create_new_accounts";
    const KEY_NEW_ACCOUNT_ROLES = "new_account_roles";
    const LANG_MODULE = ConfigCtrl::LANG_MODULE;


    /**
     * ConfigFormGUI constructor
     *
     * @param ConfigCtrl $parent
     */
    public function __construct(ConfigCtrl $parent)
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
                return self::srGoogleAccountAuth()->config()->getValue($key);
        }
    }


    /**
     * @inheritDoc
     */
    protected function initCommands()/*: void*/
    {
        $this->addCommandButton(ConfigCtrl::CMD_UPDATE_CONFIGURE, $this->txt("save"));
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*: void*/
    {
        $this->fields = [
            self::KEY_CLIENT_ID           => [
                self::PROPERTY_CLASS    => ilTextInputGUI::class,
                self::PROPERTY_REQUIRED => true
            ],
            self::KEY_CLIENT_SECRET       => [
                self::PROPERTY_CLASS    => ilTextInputGUI::class,
                self::PROPERTY_REQUIRED => true
            ],
            self::KEY_CREATE_NEW_ACCOUNTS => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class,
                self::PROPERTY_SUBITEMS => [
                    self::KEY_NEW_ACCOUNT_ROLES => [
                        self::PROPERTY_CLASS    => MultiSelectSearchNewInputGUI::class,
                        self::PROPERTY_REQUIRED => true,
                        self::PROPERTY_OPTIONS  => self::srGoogleAccountAuth()->ilias()->roles()->getAllRoles()
                    ]
                ]
            ]
        ];
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
        $this->setTitle($this->txt("configuration"));
    }


    /**
     * @inheritDoc
     */
    protected function storeValue(/*string*/ $key, $value)/*: void*/
    {
        switch ($key) {
            default:
                self::srGoogleAccountAuth()->config()->setValue($key, $value);
                break;
        }
    }
}
