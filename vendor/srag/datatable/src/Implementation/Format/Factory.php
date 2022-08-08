<?php

namespace srag\DataTableUI\AutoDeactivation\Implementation\Format;

use srag\DataTableUI\AutoDeactivation\Component\Format\Browser\Factory as BrowserFactoryInterface;
use srag\DataTableUI\AutoDeactivation\Component\Format\Factory as FactoryInterface;
use srag\DataTableUI\AutoDeactivation\Component\Format\Format;
use srag\DataTableUI\AutoDeactivation\Implementation\Format\Browser\Factory as BrowserFactory;
use srag\DataTableUI\AutoDeactivation\Implementation\Utils\DataTableUITrait;
use srag\DIC\AutoDeactivation\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTableUI\AutoDeactivation\Implementation\Format
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
    public function browser() : BrowserFactoryInterface
    {
        return BrowserFactory::getInstance();
    }


    /**
     * @inheritDoc
     */
    public function csv() : Format
    {
        return new CsvFormat();
    }


    /**
     * @inheritDoc
     */
    public function excel() : Format
    {
        return new ExcelFormat();
    }


    /**
     * @inheritDoc
     */
    public function html() : Format
    {
        return new HtmlFormat();
    }


    /**
     * @inheritDoc
     */
    public function pdf() : Format
    {
        return new PdfFormat();
    }
}
