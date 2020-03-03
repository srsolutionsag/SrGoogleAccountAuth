<?php

namespace srag\Plugins\SrGoogleAccountAuth\Utils;

use srag\Plugins\SrGoogleAccountAuth\Repository;

/**
 * Trait SrGoogleAccountAuthTrait
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait SrGoogleAccountAuthTrait
{

    /**
     * @return Repository
     */
    protected static function srGoogleAccountAuth() : Repository
    {
        return Repository::getInstance();
    }
}
