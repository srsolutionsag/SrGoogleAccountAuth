<?php

namespace srag\Plugins\SrGoogleAccountAuth\Access;

use ilObjUser;
use ilSrGoogleAccountAuthPlugin;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class Users
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Access
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Users {

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
	public static function getInstance(): self {
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Users constructor
	 */
	private function __construct() {

	}


	/**
	 * @param string $email
	 * @param int[]  $roles
	 *
	 * @return int
	 */
	public function createNewAccount(string $email, array $roles): int {
		$user = new ilObjUser();

		$user->setLogin($email);

		$user->setEmail($email);

		$user->setActive(true);

		$user->setTimeLimitUnlimited(true);

		$user->setIsSelfRegistered(true);

		$user->create();

		$user->saveAsNew();

		foreach ($roles as $role_id) {
			self::dic()->rbacadmin()->assignUser($role_id, $user->getId());
		}

		return $user->getId();
	}


	/**
	 * @param string $email
	 *
	 * @return int|null
	 */
	public function getUserIdByEmail(string $email)/*:int*/ {
		return ilObjUser::_lookupId(current(ilObjUser::getUserLoginsByEmail($email)));
	}
}
