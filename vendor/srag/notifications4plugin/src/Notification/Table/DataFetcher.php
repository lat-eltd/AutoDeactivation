<?php

namespace srag\Notifications4Plugin\AutoDeactivation\Notification\Table;

use srag\DataTableUI\AutoDeactivation\Component\Data\Data;
use srag\DataTableUI\AutoDeactivation\Component\Data\Row\RowData;
use srag\DataTableUI\AutoDeactivation\Component\Settings\Settings;
use srag\DataTableUI\AutoDeactivation\Implementation\Data\Fetcher\AbstractDataFetcher;
use srag\Notifications4Plugin\AutoDeactivation\Notification\NotificationInterface;
use srag\Notifications4Plugin\AutoDeactivation\Utils\Notifications4PluginTrait;

/**
 * Class DataFetcher
 *
 * @package srag\Notifications4Plugin\AutoDeactivation\Notification\Table
 */
class DataFetcher extends AbstractDataFetcher
{

    use Notifications4PluginTrait;

    /**
     * @inheritDoc
     */
    public function fetchData(Settings $settings) : Data
    {
        return self::dataTableUI()->data()->data(array_map(function (NotificationInterface $notification
        ) : RowData {
            return self::dataTableUI()->data()->row()->getter($notification->getId(), $notification);
        }, self::notifications4plugin()->notifications()->getNotifications($settings)),
            self::notifications4plugin()->notifications()->getNotificationsCount());
    }
}
