<?php

namespace srag\DataTableUI\AutoDeactivation\Component\Utils;

use srag\DataTableUI\AutoDeactivation\Component\Table;

/**
 * Interface TableBuilder
 *
 * @package srag\DataTableUI\AutoDeactivation\Component\Utils
 */
interface TableBuilder
{

    /**
     * @return Table
     */
    public function getTable() : Table;


    /**
     * @return string
     */
    public function render() : string;
}
