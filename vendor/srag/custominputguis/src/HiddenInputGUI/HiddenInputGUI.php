<?php

namespace srag\CustomInputGUIs\SrGoogleAccountAuth\HiddenInputGUI;

use ilHiddenInputGUI;
use srag\CustomInputGUIs\SrGoogleAccountAuth\Template\Template;
use srag\DIC\SrGoogleAccountAuth\DICTrait;

/**
 * Class HiddenInputGUI
 *
 * @package srag\CustomInputGUIs\SrGoogleAccountAuth\HiddenInputGUI
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class HiddenInputGUI extends ilHiddenInputGUI
{

    use DICTrait;

    /**
     * HiddenInputGUI constructor
     *
     * @param string $a_postvar
     */
    public function __construct(/*string*/
        $a_postvar = ""
    ) {
        parent::__construct($a_postvar);
    }


    /**
     * @inheritDoc
     */
    public function render() : string
    {
        $tpl = new Template("Services/Form/templates/default/tpl.property_form.html", true, true);

        $this->insert($tpl);

        return self::output()->getHTML($tpl);
    }
}
