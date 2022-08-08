<?php

namespace srag\Notifications4Plugin\AutoDeactivation\Notification;

use ilDateTime;
use srag\DIC\AutoDeactivation\DICTrait;
use srag\Notifications4Plugin\AutoDeactivation\Notification\Form\FormBuilder;
use srag\Notifications4Plugin\AutoDeactivation\Notification\Table\TableBuilder;
use srag\Notifications4Plugin\AutoDeactivation\Utils\Notifications4PluginTrait;
use stdClass;

/**
 * Class Factory
 *
 * @package srag\Notifications4Plugin\AutoDeactivation\Notification
 */
final class Factory implements FactoryInterface
{

    use DICTrait;
    use Notifications4PluginTrait;

    /**
     * @var FactoryInterface|null
     */
    protected static $instance = null;


    /**
     * Factory constructor
     */
    private function __construct()
    {

    }


    /**
     * @return FactoryInterface
     */
    public static function getInstance() : FactoryInterface
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * @inheritDoc
     */
    public function fromDB(stdClass $data) : NotificationInterface
    {
        $notification = $this->newInstance();

        $notification->setId($data->id);
        $notification->setName($data->name);
        $notification->setTitle($data->title);
        $notification->setDescription($data->description);
        $notification->setParser($data->parser);
        $notification->setParserOptions(json_decode($data->parser_options, true) ?? []);
        $notification->setSubjects(json_decode($data->subject, true) ?? []);
        $notification->setTexts(json_decode($data->text, true) ?? []);
        $notification->setCreatedAt(new ilDateTime($data->created_at, IL_CAL_DATETIME));
        $notification->setUpdatedAt(new ilDateTime($data->updated_at, IL_CAL_DATETIME));

        if (isset($data->default_language)) {
            $notification->default_language = $data->default_language;
        }

        return $notification;
    }


    /**
     * @inheritDoc
     */
    public function newFormBuilderInstance(NotificationCtrl $parent, NotificationInterface $notification) : FormBuilder
    {
        $form = new FormBuilder($parent, $notification);

        return $form;
    }


    /**
     * @inheritDoc
     */
    public function newInstance() : NotificationInterface
    {
        $notification = new Notification();

        return $notification;
    }


    /**
     * @inheritDoc
     */
    public function newTableBuilderInstance(NotificationsCtrl $parent) : TableBuilder
    {
        $table = new TableBuilder($parent);

        return $table;
    }
}
