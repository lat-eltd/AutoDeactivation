<?php

namespace srag\DataTableUI\AutoDeactivation\Component\Format\Browser\Filter;

use srag\CustomInputGUIs\AutoDeactivation\FormBuilder\FormBuilder;
use srag\DataTableUI\AutoDeactivation\Component\Format\Browser\BrowserFormat;
use srag\DataTableUI\AutoDeactivation\Component\Settings\Settings;
use srag\DataTableUI\AutoDeactivation\Component\Table;

/**
 * Interface Factory
 *
 * @package srag\DataTableUI\AutoDeactivation\Component\Format\Browser\Filter
 */
interface Factory
{

    /**
     * @param BrowserFormat $parent
     * @param Table         $component
     * @param Settings      $settings
     *
     * @return FormBuilder
     */
    public function formBuilder(BrowserFormat $parent, Table $component, Settings $settings) : FormBuilder;
}
