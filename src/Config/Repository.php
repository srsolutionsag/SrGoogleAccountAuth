<?php

namespace srag\Plugins\SrGoogleAccountAuth\Config;

use ilSrGoogleAccountAuthPlugin;
use srag\ActiveRecordConfig\SrGoogleAccountAuth\Config\AbstractFactory;
use srag\ActiveRecordConfig\SrGoogleAccountAuth\Config\AbstractRepository;
use srag\ActiveRecordConfig\SrGoogleAccountAuth\Config\Config;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class Repository
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Repository extends AbstractRepository
{

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
    protected function __construct()
    {
        parent::__construct();
    }


    /**
     * @inheritDoc
     *
     * @return Factory
     */
    public function factory() : AbstractFactory
    {
        return Factory::getInstance();
    }


    /**
     * @inheritDoc
     */
    protected function getTableName() : string
    {
        return ilSrGoogleAccountAuthPlugin::PLUGIN_ID . "_config";
    }


    /**
     * @inheritDoc
     */
    protected function getFields() : array
    {
        return [
            ConfigFormGUI::KEY_CLIENT_ID           => Config::TYPE_STRING,
            ConfigFormGUI::KEY_CLIENT_SECRET       => Config::TYPE_STRING,
            ConfigFormGUI::KEY_CREATE_NEW_ACCOUNTS => Config::TYPE_BOOLEAN,
            ConfigFormGUI::KEY_NEW_ACCOUNT_ROLES   => [Config::TYPE_JSON, []]
        ];
    }
}
