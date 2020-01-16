<?php

namespace srag\ActiveRecordConfig\SrGoogleAccountAuth\Utils;

use srag\ActiveRecordConfig\SrGoogleAccountAuth\Config\Repository as ConfigRepository;

/**
 * Trait ConfigTrait
 *
 * @package srag\ActiveRecordConfig\SrGoogleAccountAuth\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait ConfigTrait
{

    /**
     * @return ConfigRepository
     */
    protected static function config() : ConfigRepository
    {
        return ConfigRepository::getInstance();
    }
}
