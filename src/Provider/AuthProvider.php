<?php

namespace srag\Plugins\SrGoogleAccountAuth\Provider;

use ilAuthCredentials;
use ilAuthProviderInterface;
use ilAuthStatus;
use ilSrGoogleAccountAuthPlugin;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class AuthProvider
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Provider
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class AuthProvider implements ilAuthProviderInterface {

	use DICTrait;
	use SrGoogleAccountAuthTrait;
	const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
	/**
	 * @var ilAuthCredentials
	 */
	protected $credentials;


	/**
	 * AuthProvider constructor
	 *
	 * @param ilAuthCredentials $credentials
	 */
	public function __construct(ilAuthCredentials $credentials) {
		$this->credentials = $credentials;
	}


	/**
	 * @inheritdoc
	 */
	public function doAuthentication(ilAuthStatus $status): bool {
		return false;
	}
}
