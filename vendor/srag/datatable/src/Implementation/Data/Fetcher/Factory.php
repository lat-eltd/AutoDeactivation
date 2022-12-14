<?php

namespace srag\DataTableUI\AutoDeactivation\Implementation\Data\Fetcher;

use srag\DataTableUI\AutoDeactivation\Component\Data\Fetcher\DataFetcher;
use srag\DataTableUI\AutoDeactivation\Component\Data\Fetcher\Factory as FactoryInterface;
use srag\DataTableUI\AutoDeactivation\Implementation\Utils\DataTableUITrait;
use srag\DIC\AutoDeactivation\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTableUI\AutoDeactivation\Implementation\Data\Fetcher
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
    public function staticData(array $data, string $id_key) : DataFetcher
    {
        return new StaticDataFetcher($data, $id_key);
    }
}
