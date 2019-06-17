<?php

namespace srag\Plugins\SrGoogleAccountAuth\Utils;

use srag\Plugins\SrGoogleAccountAuth\Access\Access;
use srag\Plugins\SrGoogleAccountAuth\Access\Ilias;
use srag\Plugins\SrGoogleAccountAuth\Authentication\Authentication;
use srag\Plugins\SrGoogleAccountAuth\Client\Client;

/**
 * Trait SrGoogleAccountAuthTrait
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait SrGoogleAccountAuthTrait {

	/**
	 * @return Access
	 */
	protected static function access(): Access {
		return Access::getInstance();
	}


	/**
	 * @return Authentication
	 */
	protected static function authentication(): Authentication {
		return Authentication::getInstance();
	}


	/**
	 * @return Client
	 */
	protected static function client(): Client {
		return Client::getInstance();
	}


	/**
	 * @return Ilias
	 */
	protected static function ilias(): Ilias {
		return Ilias::getInstance();
	}
}
