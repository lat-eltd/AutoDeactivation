<?php

namespace srag\DataTableUI\AutoDeactivation\Component\Column\Formatter;

use srag\DataTableUI\AutoDeactivation\Component\Column\Column;
use srag\DataTableUI\AutoDeactivation\Component\Data\Row\RowData;
use srag\DataTableUI\AutoDeactivation\Component\Format\Format;

/**
 * Interface Formatter
 *
 * @package srag\DataTableUI\AutoDeactivation\Component\Column\Formatter
 */
interface Formatter
{

    /**
     * @param Format $format
     * @param Column $column
     * @param string $table_id
     *
     * @return string
     */
    public function formatHeaderCell(Format $format, Column $column, string $table_id) : string;


    /**
     * @param Format  $format
     * @param mixed   $value
     * @param Column  $column
     * @param RowData $row
     * @param string  $table_id
     *
     * @return string
     */
    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id) : string;
}
