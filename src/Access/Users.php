<?php

namespace srag\Plugins\SrGoogleAccountAuth\Access;

use ilDBConstants;
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
final class Users
{

    use DICTrait;
    use SrGoogleAccountAuthTrait;
    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Users constructor
     */
    private function __construct()
    {

    }


    /**
     * @param string $login
     * @param string $email
     * @param string $gender
     * @param string $first_name
     * @param string $last_name
     * @param string $external_account
     * @param int[]  $roles
     *
     * @return int
     */
    public function createNewAccount(string $login, string $email, string $gender, string $first_name, string $last_name, string $external_account, array $roles) : int
    {
        $user = new ilObjUser();

        $user->setLogin($login);

        $user->setEmail($email);

        $user->setGender($gender);

        $user->setFirstname($first_name);

        $user->setLastname($last_name);

        $user->setExternalAccount($external_account);

        $user->setActive(true);

        $user->setTimeLimitUnlimited(true);

        $user->create();

        $user->saveAsNew();

        foreach ($roles as $role_id) {
            self::dic()->rbac()->admin()->assignUser($role_id, $user->getId());
        }

        return $user->getId();
    }


    /**
     * @param string $external_account
     *
     * @return int|null
     */
    public function getUserIdByExternalAccount(string $external_account)/*:?int*/
    {
        $result = self::dic()->database()
            ->queryF('SELECT usr_id FROM usr_data WHERE ext_account=%s', [ilDBConstants::T_TEXT], [$external_account]);

        if (($row = $result->fetchAssoc()) !== false) {
            return intval($row["usr_id"]);
        } else {
            return null;
        }
    }


    /**
     * @param string $email
     *
     * @return int|null
     */
    public function getUserIdByEmail(string $email)/*:?int*/
    {
        return ilObjUser::_lookupId(current(self::version()->is54() ? ilObjUser::getUserLoginsByEmail($email) : ilObjUser::_getUserIdsByEmail($email)));
    }


    /**
     * @param int    $user_id
     * @param string $ext_id
     */
    public function updateExtId(int $user_id, string $ext_id)/*:void*/
    {
        $user = new ilObjUser($user_id);

        if (empty($user->getExternalAccount()) && !empty($ext_id)) {
            $user->setExternalAccount($ext_id);

            $user->update();
        }
    }
}
