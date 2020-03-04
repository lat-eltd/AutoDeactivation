<?php

namespace srag\Plugins\AutoDeactivation\Notification;

use ilDate;

/**
 * Class LastNotifiedRepository
 *
 * @package srag\Plugins\AutoDeactivation\Notification
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class LastNotifiedRepository
{

    /**
     * @param int $user_id
     * @return ilDate|null
     */
    public function getLastNotificationDateOfUser(int $user_id)
    {
        /** @var LastNotified $last_notified */
        $last_notified = LastNotified::find($user_id);
        return $last_notified instanceof LastNotified ? $last_notified->getDate() : null;
    }


    /**
     * @param int $user_id
     */
    public function userNotified(int $user_id)
    {
        /** @var LastNotified $last_notified */
        $last_notified = LastNotified::where(['user_id' => $user_id])->first();
        if (is_null($last_notified)) {
            $last_notified = new LastNotified();
            $last_notified->setUserId($user_id);
        }
        $last_notified->setDate(new ilDate(time(), IL_CAL_UNIX));
        $last_notified->store();
    }
}