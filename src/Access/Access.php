<?php

namespace srag\Plugins\SrGoogleAccountAuth\Access;

use ilSrGoogleAccountAuthPlugin;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class Access
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Access
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Access
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
     * Access constructor
     */
    private function __construct()
    {

    }
}
