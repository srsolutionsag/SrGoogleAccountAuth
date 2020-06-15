<?php

namespace srag\Plugins\SrGoogleAccountAuth\Authentication;

use ilSrGoogleAccountAuthPlugin;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class Repository
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Authentication
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Repository
{

    use SrGoogleAccountAuthTrait;
    use DICTrait;

    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Repository constructor
     */
    private function __construct()
    {

    }


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
     * @internal
     */
    public function dropTables()/*:void*/
    {

    }


    /**
     * @return Factory
     */
    public function factory() : Factory
    {
        return Factory::getInstance();
    }


    /**
     * @param bool $target_fallback
     *
     * @return string
     */
    public function getState(bool $target_fallback = true) : string
    {
        $state = strval(filter_input(INPUT_GET, "state"));

        if (!empty($state)) {
            return base64_decode(strtr($state, "-_,", "+/="));
        } else {
            if ($target_fallback) {
                return $this->getTarget();
            } else {
                return "";
            }
        }
    }


    /**
     * @return string
     */
    public function getTarget() : string
    {
        return strval(filter_input(INPUT_GET, "target"));
    }


    /**
     * @internal
     */
    public function installTables()/*:void*/
    {

    }
}
