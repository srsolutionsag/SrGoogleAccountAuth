<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;
use srag\RemovePluginDataConfirm\SrGoogleAccountAuth\AbstractRemovePluginDataConfirm;

/**
 * Class SrGoogleAccountAuthRemoveDataConfirm
 *
 * @author            studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy SrGoogleAccountAuthRemoveDataConfirm: ilUIPluginRouterGUI
 */
class SrGoogleAccountAuthRemoveDataConfirm extends AbstractRemovePluginDataConfirm
{

    use SrGoogleAccountAuthTrait;
    const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
}
