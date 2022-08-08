<?php

namespace srag\Notifications4Plugin\AutoDeactivation\Parser;

use srag\Notifications4Plugin\AutoDeactivation\Notification\NotificationsCtrl;
use Twig_Environment;
use Twig_Error;
use Twig_Loader_String;

/**
 * Class twigParser
 *
 * @package srag\Notifications4Plugin\AutoDeactivation\Parser
 */
class twigParser extends AbstractParser
{

    const DOC_LINK = "https://twig.symfony.com/doc/1.x/templates.html";
    const NAME = "twig";


    /**
     * twigParser constructor
     *
     * @param array $options
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @inheritDoc
     */
    public function getOptionsFields() : array
    {
        return [
            "autoescape" => self::dic()
                ->ui()
                ->factory()
                ->input()
                ->field()
                ->checkbox(self::notifications4plugin()->getPlugin()->translate("parser_option_autoescape", NotificationsCtrl::LANG_MODULE))
                ->withByline(nl2br(implode("\n", [
                    self::notifications4plugin()->getPlugin()->translate("parser_option_autoescape_info_1", NotificationsCtrl::LANG_MODULE, ["|raw"]),
                    self::notifications4plugin()->getPlugin()->translate("parser_option_autoescape_info_2", NotificationsCtrl::LANG_MODULE, ["|e"]),
                    "<b>" . self::notifications4plugin()->getPlugin()->translate("parser_option_autoescape_info_3", NotificationsCtrl::LANG_MODULE) . "</b>",
                    self::notifications4plugin()->getPlugin()->translate("parser_option_autoescape_info_4", NotificationsCtrl::LANG_MODULE)
                ]), false))
        ];
    }


    /**
     * @inheritDoc
     *
     * @throws Twig_Error
     */
    public function parse(string $text, array $placeholders = [], array $options = []) : string
    {
        $loader = new Twig_Loader_String();

        $twig = new Twig_Environment($loader, [
            "autoescape" => boolval($options["autoescape"])
        ]);

        return $this->fixLineBreaks($twig->render($text, $placeholders));
    }
}
