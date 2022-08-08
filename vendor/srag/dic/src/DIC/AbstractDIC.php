<?php

namespace srag\DIC\AutoDeactivation\DIC;

use ILIAS\DI\Container;
use srag\DIC\AutoDeactivation\Database\DatabaseDetector;
use srag\DIC\AutoDeactivation\Database\DatabaseInterface;

/**
 * Class AbstractDIC
 *
 * @package srag\DIC\AutoDeactivation\DIC
 */
abstract class AbstractDIC implements DICInterface
{

    /**
     * @var Container
     */
    protected $dic;


    /**
     * @inheritDoc
     */
    public function __construct(Container &$dic)
    {
        $this->dic = &$dic;
    }


    /**
     * @inheritDoc
     */
    public function database() : DatabaseInterface
    {
        return DatabaseDetector::getInstance($this->databaseCore());
    }
}
