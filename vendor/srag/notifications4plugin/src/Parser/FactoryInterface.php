<?php

namespace srag\Notifications4Plugin\AutoDeactivation\Parser;

/**
 * Interface FactoryInterface
 *
 * @package srag\Notifications4Plugin\AutoDeactivation\Parser
 */
interface FactoryInterface
{

    /**
     * @return twigParser
     */
    public function twig() : twigParser;
}
