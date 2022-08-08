<?php

namespace srag\DataTableUI\AutoDeactivation\Component\Data\Fetcher;

/**
 * Interface Factory
 *
 * @package srag\DataTableUI\AutoDeactivation\Component\Data\Fetcher
 */
interface Factory
{

    /**
     * @param object[] $data
     * @param string   $id_key
     *
     * @return DataFetcher
     */
    public function staticData(array $data, string $id_key) : DataFetcher;
}
