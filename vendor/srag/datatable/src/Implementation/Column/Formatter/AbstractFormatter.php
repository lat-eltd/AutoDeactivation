<?php

namespace srag\DataTableUI\AutoDeactivation\Implementation\Column\Formatter;

use srag\DataTableUI\AutoDeactivation\Component\Column\Formatter\Formatter;
use srag\DataTableUI\AutoDeactivation\Implementation\Utils\DataTableUITrait;
use srag\DIC\AutoDeactivation\DICTrait;

/**
 * Class AbstractFormatter
 *
 * @package srag\DataTableUI\AutoDeactivation\Implementation\Column\Formatter
 */
abstract class AbstractFormatter implements Formatter
{

    use DICTrait;
    use DataTableUITrait;

    /**
     * AbstractFormatter constructor
     */
    public function __construct()
    {

    }
}
