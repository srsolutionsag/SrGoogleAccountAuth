<?php

namespace srag\DIC\SrGoogleAccountAuth\DIC;

use srag\DIC\SrGoogleAccountAuth\Database\DatabaseDetector;
use srag\DIC\SrGoogleAccountAuth\Database\DatabaseInterface;

/**
 * Class AbstractDIC
 *
 * @package srag\DIC\SrGoogleAccountAuth\DIC
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractDIC implements DICInterface {

	/**
	 * AbstractDIC constructor
	 */
	protected function __construct() {

	}


	/**
	 * @inheritdoc
	 */
	public function database(): DatabaseInterface {
		return DatabaseDetector::getInstance($this->databaseCore());
	}
}
