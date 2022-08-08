<?php

namespace srag\DataTableUI\AutoDeactivation\Implementation\Format\Browser;

use srag\DataTableUI\AutoDeactivation\Component\Format\Browser\BrowserFormat;
use srag\DataTableUI\AutoDeactivation\Component\Format\Browser\Factory as FactoryInterface;
use srag\DataTableUI\AutoDeactivation\Component\Format\Browser\Filter\Factory as FilterFactoryInterface;
use srag\DataTableUI\AutoDeactivation\Implementation\Format\Browser\Filter\Factory as FilterFactory;
use srag\DataTableUI\AutoDeactivation\Implementation\Utils\DataTableUITrait;
use srag\DIC\AutoDeactivation\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTableUI\AutoDeactivation\Implementation\Format\Browser
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
    public function default() : BrowserFormat
    {
        return new DefaultBrowserFormat();
    }


    /**
     * @inheritDoc
     */
    public function filter() : FilterFactoryInterface
    {
        return FilterFactory::getInstance();
    }
}
