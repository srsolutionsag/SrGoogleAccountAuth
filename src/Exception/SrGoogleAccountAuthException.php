<?php

namespace srag\Plugins\SrGoogleAccountAuth\Exception;

use ilException;

/**
 * Class SrGoogleAccountAuthException
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Exception
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SrGoogleAccountAuthException extends ilException
{

    /**
     * SrGoogleAccountAuthException constructor
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct($message, $code);
    }
}
