<?php

$a=getcwd();
chdir(__DIR__ . "/../../../../../../..");

require_once __DIR__ . "/../../../../../../../libs/composer/vendor/autoload.php";
require_once __DIR__ . "/vendor/autoload.php";

use srag\DIC\SrGoogleAccountAuth\DICStatic;
use srag\Plugins\SrGoogleAccountAuth\Provider\AuthProvider;

ilInitialisation::initILIAS();

DICStatic::dic()->ctrl()->setTargetScript("../../../../../../../ilias.php"); // Fix ILIAS 5.3 bug

DICStatic::dic()->ctrl()->initBaseClass(ilStartUpGUI::class); // Fix ILIAS bug

// Simulate POST
DICStatic::dic()->ctrl()->setCmd("doStandardAuthentication");
$_POST["username"] = "no";
$_POST["password"] = "no";
$_POST["auth_mode"] = AuthProvider::AUTH_NAME;

// Call AuthProvider
DICStatic::dic()->ctrl()->forwardCommand(new ilStartUpGUI());
