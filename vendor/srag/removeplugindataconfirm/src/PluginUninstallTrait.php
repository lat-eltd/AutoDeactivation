<?php

namespace srag\RemovePluginDataConfirm\AutoDeactivation;

/**
 * Trait PluginUninstallTrait
 *
 * @package srag\RemovePluginDataConfirm\AutoDeactivation
 */
trait PluginUninstallTrait
{

    use BasePluginUninstallTrait;

    /**
     * @internal
     */
    protected final function afterUninstall() : void
    {

    }


    /**
     * @return bool
     *
     * @internal
     */
    protected final function beforeUninstall() : bool
    {
        return $this->pluginUninstall();
    }
}
