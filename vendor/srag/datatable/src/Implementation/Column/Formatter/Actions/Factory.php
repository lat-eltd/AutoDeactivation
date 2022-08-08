<?php

namespace srag\DataTableUI\AutoDeactivation\Implementation\Column\Formatter\Actions;

use srag\DataTableUI\AutoDeactivation\Component\Column\Formatter\Actions\ActionsFormatter;
use srag\DataTableUI\AutoDeactivation\Component\Column\Formatter\Actions\Factory as FactoryInterface;
use srag\DataTableUI\AutoDeactivation\Implementation\Utils\DataTableUITrait;
use srag\DIC\AutoDeactivation\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTableUI\AutoDeactivation\Implementation\Column\Formatter\Actions
 */
class Factory implements FactoryInterface
{

    use DICTrait;
    use DataTableUITrait;

    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Factory constructor
     */
    private function __construct()
    {

    }


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * @inheritDoc
     */
    public function actionsDropdown() : ActionsFormatter
    {
        return new ActionsDropdownFormatter();
    }


    /**
     * @inheritDoc
     */
    public function sort() : ActionsFormatter
    {
        return new SortFormatter();
    }
}
