<?php

namespace srag\Plugins\SrGoogleAccountAuth;

use ilSrGoogleAccountAuthPlugin;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Access\Ilias;
use srag\Plugins\SrGoogleAccountAuth\Authentication\Repository as AuthenticationRepository;
use srag\Plugins\SrGoogleAccountAuth\Client\Client;
use srag\Plugins\SrGoogleAccountAuth\Config\Config;
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
     *
     */
    public function dropTables()/*: void*/
    {
        self::dic()->database()->dropTable(Config::TABLE_NAME, false);
        $this->authentication()->dropTables();
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
        Config::updateDB();
        $this->authentication()->installTables();
    }
}
