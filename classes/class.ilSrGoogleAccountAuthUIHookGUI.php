<?php

use srag\DIC\SrGoogleAccountAuth\DICTrait;
use srag\Plugins\SrGoogleAccountAuth\Utils\SrGoogleAccountAuthTrait;

/**
 * Class ilSrGoogleAccountAuthUIHookGUI
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilSrGoogleAccountAuthUIHookGUI extends ilUIHookPluginGUI {

	use DICTrait;
	use SrGoogleAccountAuthTrait;
	const PLUGIN_CLASS_NAME = ilSrGoogleAccountAuthPlugin::class;
	const LOGIN_PHP = "/login.php";
	const LOGIN_TEMPLATE_ID = "Services/Init/tpl.login.html";
	const TEMPLATE_ADD = "template_add";


	/**
	 * @param string $a_comp
	 * @param string $a_part
	 * @param array  $a_par
	 *
	 * @return array
	 */
	public function getHTML(/*string*/ $a_comp, /*string*/ $a_part, /*array*/ $a_par = []): array {

		if ($a_par["tpl_id"] === self::LOGIN_TEMPLATE_ID && $a_part === self::TEMPLATE_ADD) {

			$html = self::output()->getHTML(self::dic()->ui()->factory()->link()->standard(self::plugin()->translate("login"), self::client()
				->createAuthUrl()));

			return [ "mode" => self::PREPEND, "html" => $html ];
		}

		return parent::getHTML($a_comp, $a_part, $a_par);
	}


	/**
	 *
	 */
	public function gotoHook()/*: void*/ {
		$target = filter_input(INPUT_GET, "target");

		$matches = [];
		preg_match("/^uihk_" . ilSrGoogleAccountAuthPlugin::PLUGIN_ID . "(_(.*))?/uim", $target, $matches);

		if (is_array($matches) && count($matches) >= 1) {

			try {
				self::authentication()->doAuthentication();
			} catch (Throwable $ex) {
				self::dic()->logger()->root()->log($ex->__toString(), ilLogLevel::ERROR);

				die();
			}
		}
	}
}
