<?php

namespace srag\Plugins\SrGoogleAccountAuth\Utils;

use srag\Plugins\SrGoogleAccountAuth\Access\Access;
use srag\Plugins\SrGoogleAccountAuth\Access\Ilias;

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
	 * @return Ilias
	 */
	protected static function ilias(): Ilias {
		return Ilias::getInstance();
	}
}
