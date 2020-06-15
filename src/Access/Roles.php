<?php

namespace srag\Plugins\SrGoogleAccountAuth\Access;

use ilSrGoogleAccountAuthPlugin;
use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class Roles
 *
 * @package srag\Plugins\SrGoogleAccountAuth\Access
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Roles
{

    use DICTrait;
    use SrGoogleAccountAuthTrait;

    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Roles constructor
     */
    private function __construct()
    {

    }


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
     * @return array
     */
    public function getAllRoles() : array
    {
        /**
         * @var array $global_roles
         * @var array $roles
         */

        $global_roles = self::dic()->rbac()->review()->getRolesForIDs(self::dic()->rbac()->review()->getGlobalRoles(), false);

        $roles = [];
        foreach ($global_roles as $global_role) {
            $roles[$global_role["rol_id"]] = $global_role["title"];
        }

        return $roles;
    }
}
