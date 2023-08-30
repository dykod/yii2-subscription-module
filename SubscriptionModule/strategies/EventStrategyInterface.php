<?php

namespace common\modules\SubscriptionModule\strategies;

interface EventStrategyInterface
{
    public function notify($eventData);
}