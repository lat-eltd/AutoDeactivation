<?php

namespace srag\DataTableUI\AutoDeactivation\Implementation\Data\Fetcher;

use srag\DataTableUI\AutoDeactivation\Component\Data\Fetcher\DataFetcher;
use srag\DataTableUI\AutoDeactivation\Component\Table;
use srag\DataTableUI\AutoDeactivation\Implementation\Utils\DataTableUITrait;
use srag\DIC\AutoDeactivation\DICTrait;

/**
 * Class AbstractDataFetcher
 *
 * @package srag\DataTableUI\AutoDeactivation\Implementation\Data\Fetcher
 */
abstract class AbstractDataFetcher implements DataFetcher
{

    use DICTrait;
    use DataTableUITrait;

    /**
     * AbstractDataFetcher constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function getNoDataText(Table $component) : string
    {
        return $component->getPlugin()->translate("no_data", Table::LANG_MODULE);
    }


    /**
     * @inheritDoc
     */
    public function isFetchDataNeedsFilterFirstSet() : bool
    {
        return false;
    }
}
