<?php

namespace srag\DataTableUI\AutoDeactivation\Implementation\Data\Row;

use srag\CustomInputGUIs\AutoDeactivation\PropertyFormGUI\Items\Items;

/**
 * Class GetterRowData
 *
 * @package srag\DataTableUI\AutoDeactivation\Implementation\Data\Row
 */
class GetterRowData extends AbstractRowData
{

    /**
     * @inheritDoc
     */
    public function __invoke(string $key)
    {
        return Items::getter($this->getOriginalData(), $key);
    }
}
