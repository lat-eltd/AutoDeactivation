<?php

namespace srag\DataTableUI\AutoDeactivation\Implementation\Utils;

use srag\DataTableUI\AutoDeactivation\Component\Factory as FactoryInterface;
use srag\DataTableUI\AutoDeactivation\Implementation\Factory;

/**
 * Trait DataTableUITrait
 *
 * @package srag\DataTableUI\AutoDeactivation\Implementation\Utils
 */
trait DataTableUITrait
{

    /**
     * @return FactoryInterface
     */
    protected static function dataTableUI() : FactoryInterface
    {
        return Factory::getInstance();
    }
}
