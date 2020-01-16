<?php

namespace srag\Plugins\SrGoogleAccountAuth;

use ilSrGoogleAccountAuthPlugin;
use srag\ActiveRecordConfig\SrGoogleAccountAuth\Config\Config;
use srag\ActiveRecordConfig\SrGoogleAccountAuth\Config\Repository as ConfigRepository;
use srag\ActiveRecordConfig\SrGoogleAccountAuth\Utils\ConfigTrait;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Access\Ilias;
use srag\Plugins\SrGoogleAccountAuth\Authentication\Repository as AuthenticationRepository;
use srag\Plugins\SrGoogleAccountAuth\Client\Client;
use srag\Plugins\SrGoogleAccountAuth\Config\ConfigFormGUI;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class Repository
 *
 * @package srag\Plugins\SrGoogleAccountAuth
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Repository
{

    use DICTrait;
    use SrGoogleAccountAuthTrait;
    use ConfigTrait {
        config as protected _config;
    }
    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    /**
     * @var self
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
     * Repository constructor
     */
    private function __construct()
    {
        $this->config()->withTableName(ilSrGoogleAccountAuthPlugin::PLUGIN_ID . "_config")->withFields([
            ConfigFormGUI::KEY_CLIENT_ID           => Config::TYPE_STRING,
            ConfigFormGUI::KEY_CLIENT_SECRET       => Config::TYPE_STRING,
            ConfigFormGUI::KEY_CREATE_NEW_ACCOUNTS => Config::TYPE_BOOLEAN,
            ConfigFormGUI::KEY_NEW_ACCOUNT_ROLES   => [Config::TYPE_JSON, []]
        ]);
    }


    /**
     * @return AuthenticationRepository
     */
    public function authentication() : AuthenticationRepository
    {
        return AuthenticationRepository::getInstance();
    }


    /**
     * @return Client
     */
    public function client() : Client
    {
        return Client::getInstance();
    }


    /**
     * @inheritDoc
     */
    public function config() : ConfigRepository
    {
        return self::_config();
    }


    /**
     *
     */
    public function dropTables()/*: void*/
    {
        $this->authentication()->dropTables();
        $this->config()->dropTables();
    }


    /**
     * @return Ilias
     */
    public function ilias() : Ilias
    {
        return Ilias::getInstance();
    }


    /**
     *
     */
    public function installTables()/*: void*/
    {
        $this->authentication()->installTables();
        $this->config()->installTables();
    }
}
