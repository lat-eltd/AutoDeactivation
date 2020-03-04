<?php

namespace srag\Plugins\AutoDeactivation\User;

use ilAuthUtils;
use ilDate;
use ILIAS\DI\Container;
use ilObjUser;
use srag\Plugins\AutoDeactivation\Config\ConfigFormGUI;
use srag\Plugins\AutoDeactivation\Config\Repository as ConfigRepository;

/**
 * Class Repository
 *
 * @package srag\Plugins\AutoDeactivation\Job\User
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class Repository
{

    /**
     * @var Container
     */
    protected $dic;
    /**
     * @var ConfigRepository
     */
    protected $config_repository;


    /**
     * Repository constructor.
     *
     * @param Container        $dic
     * @param ConfigRepository $config_repository
     */
    public function __construct(Container $dic, ConfigRepository $config_repository)
    {
        $this->dic = $dic;
        $this->config_repository = $config_repository;
    }


    /**
     * @return ilObjUser[]
     */
    public function getUsersForWarningNotification() : array
    {
        $days_to_deactivation = $this->config_repository->getValue(ConfigFormGUI::KEY_THRESHOLD_IN_DAYS);
        $days_before_warning = $this->config_repository->getValue(ConfigFormGUI::KEY_DAYS_WARNING);
        $days_from_last_login = $days_to_deactivation - $days_before_warning;

        $date_threshold = new ilDate(time() - ($days_from_last_login * 24 * 60 * 60), IL_CAL_UNIX);
        $date_threshold_string = $date_threshold->get(IL_CAL_FKT_DATE, 'Y-m-d');
        $date_max = new ilDate(time() - ($days_to_deactivation * 24 * 60 * 60), IL_CAL_UNIX);
        $date_max_string = $date_max->get(IL_CAL_FKT_DATE, 'Y-m-d');
        $date_threshold_last_notified = new ilDate(time() - ($days_before_warning * 24 * 60 * 60), IL_CAL_UNIX);
        $date_threshold_last_notified_string = $date_threshold_last_notified->get(IL_CAL_FKT_DATE, 'Y-m-d');

        $query = '
            SELECT * FROM usr_data u
            LEFT JOIN autod_last_notified ln ON u.usr_id = ln.user_id
            WHERE (ln.date IS NULL OR ln.date < ' . $this->dic->database()->quote($date_threshold_last_notified_string, 'date') . ')
            AND ((u.last_login <= ' . $this->dic->database()->quote($date_threshold_string, 'date') . '
                    AND u.last_login > ' . $this->dic->database()->quote($date_max_string, 'date') . ')
                OR (u.last_login IS NULL AND u.create_date <= ' . $this->dic->database()->quote($date_threshold_string, 'date') . '
                    AND u.create_date > ' . $this->dic->database()->quote($date_max_string, 'date') . '))
            AND u.active = 1 ' . '
            AND u.usr_id NOT IN (6,13) ' .
            $this->getAuthModeWhere();

        $users = [];
        $res = $this->dic->database()->query($query);
        while ($rec = $this->dic->database()->fetchAssoc($res)) {
            $users[] = new ilObjUser($rec['usr_id']);
        }
        return $users;
    }


    /**
     * @return ilObjUser[]
     */
    public function getUsersToBeDeactivated() : array
    {
        $days_to_deactivation = $this->config_repository->getValue(ConfigFormGUI::KEY_THRESHOLD_IN_DAYS);
        $date_threshold = new ilDate(time() - ($days_to_deactivation * 24 * 60 * 60), IL_CAL_UNIX);
        $date_threshold_string = $date_threshold->get(IL_CAL_FKT_DATE, 'Y-m-d');

        $query = '
            SELECT * FROM usr_data u
            WHERE (u.last_login <= ' . $this->dic->database()->quote($date_threshold_string, 'date') . '
                OR (u.last_login IS NULL AND u.create_date <= ' . $this->dic->database()->quote($date_threshold_string, 'date') . '))
            AND u.active = 1 ' . '
            AND u.usr_id NOT IN (6,13) ' .
            $this->getAuthModeWhere();

        $users = [];
        $res = $this->dic->database()->query($query);
        while ($rec = $this->dic->database()->fetchAssoc($res)) {
            $users[] = new ilObjUser($rec['usr_id']);
        }
        return $users;
    }


    /**
     * @return string
     */
    protected function getAuthModeWhere() : string
    {
        $local_only = $this->config_repository->getValue(ConfigFormGUI::KEY_LOCAL_USERS_ONLY) == 1;
        if (!$local_only) {
            return '';
        }
        if (ilAuthUtils::_getAuthMode('default') == AUTH_LOCAL) {
            return ' AND u.auth_mode IN ("default", "local")';
        }
        return ' AND u.auth_mode = "local"';
    }
}