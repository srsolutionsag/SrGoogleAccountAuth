<?php

namespace srag\Plugins\SrGoogleAccountAuth\Config\Form;

use ilSrGoogleAccountAuthPlugin;
use srag\CustomInputGUIs\SrGoogleAccountAuth\FormBuilder\AbstractFormBuilder;
use srag\CustomInputGUIs\SrGoogleAccountAuth\InputGUIWrapperUIInputComponent\InputGUIWrapperUIInputComponent;
use srag\CustomInputGUIs\SrGoogleAccountAuth\MultiSelectSearchNewInputGUI\MultiSelectSearchNewInputGUI;
use srag\Plugins\SrGoogleAccountAuth\Config\ConfigCtrl;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class FormBuilder
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Config\Form
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class FormBuilder extends AbstractFormBuilder
{

    use SrGoogleAccountAuthTrait;

    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    const KEY_CLIENT_ID = "client_id";
    const KEY_CLIENT_SECRET = "client_secret";
    const KEY_CREATE_NEW_ACCOUNTS = "create_new_accounts";
    const KEY_NEW_ACCOUNT_ROLES = "new_account_roles";


    /**
     * @inheritDoc
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
    protected function getButtons() : array
    {
        $buttons = [
            ConfigCtrl::CMD_UPDATE_CONFIGURE => self::plugin()->translate("save", ConfigCtrl::LANG_MODULE)
        ];

        return $buttons;
    }


    /**
     * @inheritDoc
     */
    protected function getData() : array
    {
        $data = [
            self::KEY_CLIENT_ID           => self::srGoogleAccountAuth()->config()->getValue(self::KEY_CLIENT_ID),
            self::KEY_CLIENT_SECRET       => self::srGoogleAccountAuth()->config()->getValue(self::KEY_CLIENT_SECRET),
            self::KEY_CREATE_NEW_ACCOUNTS => [
                "value"        => self::srGoogleAccountAuth()->config()->getValue(self::KEY_CREATE_NEW_ACCOUNTS),
                "group_values" => [
                    "dependant_group" => [
                        self::KEY_NEW_ACCOUNT_ROLES => self::srGoogleAccountAuth()->config()->getValue(self::KEY_NEW_ACCOUNT_ROLES)
                    ]
                ]
            ]
        ];

        return $data;
    }


    /**
     * @inheritDoc
     */
    protected function getFields() : array
    {
        $create_new_accounts_fields = [
            self::KEY_NEW_ACCOUNT_ROLES => (new InputGUIWrapperUIInputComponent(new MultiSelectSearchNewInputGUI(self::plugin()
                ->translate(self::KEY_NEW_ACCOUNT_ROLES, ConfigCtrl::LANG_MODULE))))->withByline(self::plugin()
                ->translate(self::KEY_NEW_ACCOUNT_ROLES . "_info", ConfigCtrl::LANG_MODULE))->withRequired(true)
        ];
        $create_new_accounts_fields[self::KEY_CREATE_NEW_ACCOUNTS]->getInput()->setOptions(self::srGoogleAccountAuth()->ilias()->roles()->getAllRoles());

        $fields = [
            self::KEY_CLIENT_ID     => self::dic()->ui()->factory()->input()->field()->password(self::plugin()->translate(self::KEY_CLIENT_ID, ConfigCtrl::LANG_MODULE))->withRequired(true),
            self::KEY_CLIENT_SECRET => self::dic()->ui()->factory()->input()->field()->password(self::plugin()->translate(self::KEY_CLIENT_SECRET, ConfigCtrl::LANG_MODULE))->withRequired(true)
        ];

        if (self::version()->is6()) {
            $fields += [
                self::KEY_CREATE_NEW_ACCOUNTS => self::dic()
                    ->ui()
                    ->factory()
                    ->input()
                    ->field()
                    ->optionalGroup($create_new_accounts_fields, self::plugin()->translate(self::KEY_CREATE_NEW_ACCOUNTS, ConfigCtrl::LANG_MODULE))
            ];
        } else {
            $fields += [
                self::KEY_CREATE_NEW_ACCOUNTS => self::dic()
                    ->ui()
                    ->factory()
                    ->input()
                    ->field()
                    ->checkbox(self::plugin()->translate(self::KEY_CREATE_NEW_ACCOUNTS, ConfigCtrl::LANG_MODULE))
                    ->withDependantGroup(self::dic()->ui()->factory()->input()->field()->dependantGroup($create_new_accounts_fields))
            ];
        }

        return $fields;
    }


    /**
     * @inheritDoc
     */
    protected function getTitle() : string
    {
        return self::plugin()->translate("configuration", ConfigCtrl::LANG_MODULE);
    }


    /**
     * @inheritDoc
     */
    protected function storeData(array $data)/* : void*/
    {
        self::srGoogleAccountAuth()->config()->setValue(self::KEY_CLIENT_ID, $data[self::KEY_CLIENT_ID]->toString());
        self::srGoogleAccountAuth()->config()->setValue(self::KEY_CLIENT_SECRET, $data[self::KEY_CLIENT_SECRET]->toString());

        if (self::version()->is6()) {
            if (!empty($data[self::KEY_CREATE_NEW_ACCOUNTS])) {
                self::srGoogleAccountAuth()->config()->setValue(self::KEY_CREATE_NEW_ACCOUNTS, true);
                self::srGoogleAccountAuth()->config()->setValue(self::KEY_NEW_ACCOUNT_ROLES, (array) $data[self::KEY_CREATE_NEW_ACCOUNTS][self::KEY_NEW_ACCOUNT_ROLES]);
            } else {
                self::srGoogleAccountAuth()->config()->setValue(self::KEY_CREATE_NEW_ACCOUNTS, false);
            }
        } else {
            self::srGoogleAccountAuth()->config()->setValue(self::KEY_CREATE_NEW_ACCOUNTS, boolval($data[self::KEY_CREATE_NEW_ACCOUNTS]["value"]));
            self::srGoogleAccountAuth()
                ->config()
                ->setValue(self::KEY_NEW_ACCOUNT_ROLES, (array) (boolval($data[self::KEY_CREATE_NEW_ACCOUNTS]["value"]) ? $data[self::KEY_CREATE_NEW_ACCOUNTS]["group_values"]
                    : $data[self::KEY_CREATE_NEW_ACCOUNTS])["dependant_group"][self::KEY_NEW_ACCOUNT_ROLES]);
        }
    }
}
