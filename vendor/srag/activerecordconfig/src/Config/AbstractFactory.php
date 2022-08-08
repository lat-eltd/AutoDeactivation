<?php

namespace srag\ActiveRecordConfig\AutoDeactivation\Config;

use srag\DIC\AutoDeactivation\DICTrait;

/**
 * Class AbstractFactory
 *
 * @package srag\ActiveRecordConfig\AutoDeactivation\Config
 */
abstract class AbstractFactory
{

    use DICTrait;

    /**
     * AbstractFactory constructor
     */
    protected function __construct()
    {

    }


    /**
     * @return Config
     */
    public function newInstance() : Config
    {
        $config = new Config();

        return $config;
    }
}
