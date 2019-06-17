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
	 * @param string $login
	 * @param string $email
	 * @param string $gender
	 * @param string $first_name
	 * @param string $last_name
	 * @param string $ext_id
	 * @param int[]  $roles
	 *
	 * @return int
	 */
	public function createNewAccount(string $login, string $email, string $gender, string $first_name, string $last_name, string $ext_id, array $roles): int {
		$user = new ilObjUser();

		$user->setLogin($login);

		$user->setEmail($email);

		$user->setGender($gender);

		$user->setFirstname($first_name);

		$user->setLastname($last_name);

		$user->setExternalAccount($ext_id);

		$user->setActive(true);

		$user->setTimeLimitUnlimited(true);

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


	/**
	 * @param int    $user_id
	 * @param string $ext_id
	 */
	public function updateExtId(int $user_id, string $ext_id)/*:void*/ {
		$user = new ilObjUser($user_id);

		if (empty($user->getExternalAccount()) && !empty($ext_id)) {
			$user->setExternalAccount($ext_id);

			$user->update();
		}
	}
}
