<?php

namespace common\modules\SubscriptionModule\strategies;

use common\modules\SubscriptionModule\models\Subscription;

class EventStrategyFactory
{
    public static function create($eventType)
    {
        switch ($eventType) {
            case Subscription::EVENT_LOGIN:
                return new LoginEventStrategy();
            case Subscription::EVENT_LOGOUT:
                return new LogoutEventStrategy();
            case Subscription::EVENT_REG:
                return new RegEventStrategy();
            case Subscription::EVENT_MESSAGE:
                return new MessageEventStrategy();
            case Subscription::EVENT_VERIFY:
                return new VerifyEventStrategy();
            default:
                throw new \InvalidArgumentException("Unknown event type: $eventType");
        }
    }
}
