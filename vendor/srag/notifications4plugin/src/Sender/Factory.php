<?php

namespace srag\Notifications4Plugin\AutoDeactivation\Sender;

use srag\DIC\AutoDeactivation\DICTrait;
use srag\Notifications4Plugin\AutoDeactivation\Utils\Notifications4PluginTrait;

/**
 * Class Factory
 *
 * @package srag\Notifications4Plugin\AutoDeactivation\Sender
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
    public function externalMail(string $from = "", $to = "") : ExternalMailSender
    {
        return new ExternalMailSender($from, $to);
    }


    /**
     * @inheritDoc
     */
    public function internalMail($user_from = 0, $user_to = "") : InternalMailSender
    {
        return new InternalMailSender($user_from, $user_to);
    }


    /**
     * @inheritDoc
     */
    public function vcalendar($user_from = 0, $to = "", string $method = vcalendarSender::METHOD_REQUEST, string $uid = "", int $startTime = 0, int $endTime = 0, int $sequence = 0) : vcalendarSender
    {
        return new vcalendarSender($user_from, $to, $method, $uid, $startTime, $endTime, $sequence);
    }
}
