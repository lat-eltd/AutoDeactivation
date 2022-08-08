<?php

namespace srag\DIC\AutoDeactivation\Plugin;

/**
 * Interface Pluginable
 *
 * @package srag\DIC\AutoDeactivation\Plugin
 */
interface Pluginable
{

    /**
     * @return PluginInterface
     */
    public function getPlugin() : PluginInterface;


    /**
     * @param PluginInterface $plugin
     *
     * @return static
     */
    public function withPlugin(PluginInterface $plugin)/*: static*/ ;
}
