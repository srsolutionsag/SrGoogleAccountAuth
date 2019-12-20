<?php

namespace srag\DIC\SrGoogleAccountAuth\DIC;

use ILIAS\DI\Container;
use srag\DIC\SrGoogleAccountAuth\Database\DatabaseDetector;
use srag\DIC\SrGoogleAccountAuth\Database\DatabaseInterface;

/**
 * Class AbstractDIC
 *
 * @package srag\DIC\SrGoogleAccountAuth\DIC
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractDIC implements DICInterface
{

    /**
     * @var Container
     */
    protected $dic;


    /**
     * @inheritDoc
     */
    public function __construct(Container &$dic)
    {
        $this->dic = &$dic;
    }


    /**
     * @inheritdoc
     */
    public function database() : DatabaseInterface
    {
        return DatabaseDetector::getInstance($this->databaseCore());
    }
}
