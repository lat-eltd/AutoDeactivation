<?php

namespace srag\DataTableUI\AutoDeactivation\Component\Settings\Storage;

/**
 * Interface Factory
 *
 * @package srag\DataTableUI\AutoDeactivation\Component\Settings\Storage
 */
interface Factory
{

    /**
     * @return SettingsStorage
     */
    public function default() : SettingsStorage;
}
