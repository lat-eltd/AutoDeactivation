<?php

namespace srag\DataTableUI\AutoDeactivation\Component\Data\Fetcher;

use srag\DataTableUI\AutoDeactivation\Component\Data\Data;
use srag\DataTableUI\AutoDeactivation\Component\Settings\Settings;
use srag\DataTableUI\AutoDeactivation\Component\Table;

/**
 * Interface DataFetcher
 *
 * @package srag\DataTableUI\AutoDeactivation\Component\Data\Fetcher
 */
interface DataFetcher
{

    /**
     * @param Settings $settings
     *
     * @return Data
     */
    public function fetchData(Settings $settings) : Data;


    /**
     * @param Table $component
     *
     * @return string
     */
    public function getNoDataText(Table $component) : string;


    /**
     * @return bool
     */
    public function isFetchDataNeedsFilterFirstSet() : bool;
}
