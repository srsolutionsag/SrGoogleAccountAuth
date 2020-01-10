<?php

namespace srag\Plugins\SrGoogleAccountAuth\Config;

use ilCheckboxInputGUI;
use ilMultiSelectInputGUI;
use ilSrGoogleAccountAuthConfigGUI;
use ilSrGoogleAccountAuthPlugin;
use ilTextInputGUI;
use srag\CustomInputGUIs\SrGoogleAccountAuth\PropertyFormGUI\ConfigPropertyFormGUI;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class ConfigFormGUI
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends ConfigPropertyFormGUI
{

    use SrGoogleAccountAuthTrait;
    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    const CONFIG_CLASS_NAME = Config::class;
    const LANG_MODULE = ilSrGoogleAccountAuthConfigGUI::LANG_MODULE;


    /**
     * ConfigFormGUI constructor
     *
     * @param ilSrGoogleAccountAuthConfigGUI $parent
     */
    public function __construct(ilSrGoogleAccountAuthConfigGUI $parent)
    {
        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function initCommands()/*: void*/
    {
        $this->addCommandButton(ilSrGoogleAccountAuthConfigGUI::CMD_UPDATE_CONFIGURE, $this->txt("save"));
    }


    /**
     * @inheritDoc
     */
    protected function getValue(/*string*/ $key)
    {
        switch (true) {
            default:
                return parent::getValue($key);
        }
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*: void*/
    {
        $this->fields = [
            Config::KEY_CLIENT_ID           => [
                self::PROPERTY_CLASS    => ilTextInputGUI::class,
                self::PROPERTY_REQUIRED => true
            ],
            Config::KEY_CLIENT_SECRET       => [
                self::PROPERTY_CLASS    => ilTextInputGUI::class,
                self::PROPERTY_REQUIRED => true
            ],
            Config::KEY_CREATE_NEW_ACCOUNTS => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class,
                self::PROPERTY_SUBITEMS => [
                    Config::KEY_NEW_ACCOUNT_ROLES => [
                        self::PROPERTY_CLASS    => ilMultiSelectInputGUI::class,
                        self::PROPERTY_REQUIRED => true,
                        self::PROPERTY_OPTIONS  => self::ilias()->roles()->getAllRoles(),
                        "enableSelectAll"       => true
                    ],
                ]
            ],
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
            case Config::KEY_NEW_ACCOUNT_ROLES:
                if ($value[0] === "") {
                    array_shift($value);
                }

                $value = array_map(function (string $role_id) : int {
                    return intval($role_id);
                }, $value);
                break;

            default:
                break;
        }

        parent::storeValue($key, $value);
    }
}
