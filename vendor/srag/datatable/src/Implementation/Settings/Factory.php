<?php

namespace srag\DataTableUI\AutoDeactivation\Implementation\Settings;

use ILIAS\UI\Component\ViewControl\Pagination;
use srag\DataTableUI\AutoDeactivation\Component\Settings\Factory as FactoryInterface;
use srag\DataTableUI\AutoDeactivation\Component\Settings\Settings as SettingsInterface;
use srag\DataTableUI\AutoDeactivation\Component\Settings\Sort\Factory as SortFactoryInterface;
use srag\DataTableUI\AutoDeactivation\Component\Settings\Storage\Factory as StorageFactoryInterface;
use srag\DataTableUI\AutoDeactivation\Implementation\Settings\Sort\Factory as SortFactory;
use srag\DataTableUI\AutoDeactivation\Implementation\Settings\Storage\Factory as StorageFactory;
use srag\DataTableUI\AutoDeactivation\Implementation\Utils\DataTableUITrait;
use srag\DIC\AutoDeactivation\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTableUI\AutoDeactivation\Implementation\Settings
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
    public function settings(Pagination $pagination) : SettingsInterface
    {
        return new Settings($pagination);
    }


    /**
     * @inheritDoc
     */
    public function sort() : SortFactoryInterface
    {
        return SortFactory::getInstance();
    }


    /**
     * @inheritDoc
     */
    public function storage() : StorageFactoryInterface
    {
        return StorageFactory::getInstance();
    }
}
