<?php

namespace srag\DataTableUI\AutoDeactivation\Implementation\Data\Row;

use srag\DataTableUI\AutoDeactivation\Component\Data\Row\Factory as FactoryInterface;
use srag\DataTableUI\AutoDeactivation\Component\Data\Row\RowData;
use srag\DataTableUI\AutoDeactivation\Implementation\Utils\DataTableUITrait;
use srag\DIC\AutoDeactivation\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTableUI\AutoDeactivation\Implementation\Data\Row
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
    public function getter(string $row_id, object $original_data) : RowData
    {
        return new GetterRowData($row_id, $original_data);
    }


    /**
     * @inheritDoc
     */
    public function property(string $row_id, object $original_data) : RowData
    {
        return new PropertyRowData($row_id, $original_data);
    }
}
