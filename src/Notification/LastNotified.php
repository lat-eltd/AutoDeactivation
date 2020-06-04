<?php

namespace srag\Plugins\AutoDeactivation\Notification;

use ActiveRecord;
use ilDate;
use ilDateTime;

/**
 * Class LastNotified
 *
 * @package srag\Plugins\AutoDeactivation\Notification
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class LastNotified extends ActiveRecord
{

    const TABLE_NAME = 'autod_last_notified';


    /**
     * @return string
     */
    public function getConnectorContainerName()
    {
        return self::TABLE_NAME;
    }


    /**
     * @var int
     *
     * @db_has_field        true
     * @db_fieldtype        integer
     * @db_length           8
     * @db_is_primary       true
     */
    protected $user_id;
    /**
     * @var ilDate
     *
     * @db_has_field        true
     * @db_fieldtype        date
     */
    protected $date;


    /**
     * @return int
     */
    public function getUserId() : int
    {
        return $this->user_id;
    }


    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }


    /**
     * @return ilDate
     */
    public function getDate() : ilDate
    {
        return $this->date;
    }


    /**
     * @param ilDate $date
     */
    public function setDate(ilDate $date)
    {
        $this->date = $date;
    }


    /**
     * @param $field_name
     *
     * @return int|mixed|string
     */
    public function sleep($field_name)
    {
        switch ($field_name) {
            case 'date':
                return $this->date->get(IL_CAL_FKT_DATE, 'Y-m-d');
            default:
                return parent::sleep($field_name);
        }
    }


    /**
     * @param $field_name
     * @param $field_value
     *
     * @return mixed
     */
    public function wakeUp($field_name, $field_value)
    {
        switch ($field_name) {
            case 'date':
                return new ilDate($field_value);
            default:
                return parent::wakeUp($field_name, $field_value);
        }
    }
}