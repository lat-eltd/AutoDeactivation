<?php

namespace srag\CustomInputGUIs\AutoDeactivation;

/**
 * Trait CustomInputGUIsTrait
 *
 * @package srag\CustomInputGUIs\AutoDeactivation
 */
trait CustomInputGUIsTrait
{

    /**
     * @return CustomInputGUIs
     */
    protected static final function customInputGUIs() : CustomInputGUIs
    {
        return CustomInputGUIs::getInstance();
    }
}
