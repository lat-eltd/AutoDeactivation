<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\DIC\AutoDeactivation\Exception\DICException;
use srag\Notifications4Plugin\AutoDeactivation\Utils\Notifications4PluginTrait;
use srag\Plugins\AutoDeactivation\Utils\AutoDeactivationTrait;
use srag\RemovePluginDataConfirm\AutoDeactivation\PluginUninstallTrait;

/**
 * Class ilAutoDeactivationPlugin
 *
 * Generated by SrPluginGenerator v1.3.5
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author studer + raimann ag - Team Custom 1 <support@studer-raimann.ch>
 */
class ilAutoDeactivationPlugin extends ilCronHookPlugin
{

    use PluginUninstallTrait;
    use AutoDeactivationTrait;
    use Notifications4PluginTrait;
    const PLUGIN_ID = "autod";
    const PLUGIN_NAME = "AutoDeactivation";
    const PLUGIN_CLASS_NAME = self::class;
    /**
     * @var self|null
     */
    protected static $instance = null;

    /**
     * @var bool
     */
    protected static $init_notifications = false;

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
     * ilAutoDeactivationPlugin constructor
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @throws DICException
     */
    protected function init()
    {
        self::initNotifications();
    }


    /**
     * @throws DICException
     */
    public static function initNotifications()/*:void*/
    {
        if (!self::$init_notifications) {
            self::$init_notifications = true;

            self::notifications4plugin()->withTableNamePrefix(self::PLUGIN_ID)->withPlugin(self::plugin());
        }
    }

    /**
     * @inheritDoc
     */
    public function getPluginName() : string
    {
        return self::PLUGIN_NAME;
    }


    /**
     * @inheritDoc
     */
    public function getCronJobInstances() : array
    {
        return self::autoDeactivation()->jobs()->factory()->newInstances();
    }


    /**
     * @inheritDoc
     */
    public function getCronJobInstance(/*string*/ $a_job_id)/*: ?ilCronJob*/
    {
        return self::autoDeactivation()->jobs()->factory()->newInstanceById($a_job_id);
    }


    /**
     * @inheritDoc
     */
    public function updateLanguages(/*?array*/ $a_lang_keys = null)/*:void*/
    {
        parent::updateLanguages($a_lang_keys);

        $this->installRemovePluginDataConfirmLanguages();
        self::notifications4plugin()->installLanguages();
    }


    /**
     * @inheritDoc
     */
    protected function deleteData()/*: void*/
    {
        self::autoDeactivation()->dropTables();
    }
}
