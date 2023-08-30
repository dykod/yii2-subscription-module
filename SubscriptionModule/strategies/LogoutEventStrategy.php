<?php

namespace common\modules\SubscriptionModule\strategies;

use common\modules\SubscriptionModule\models\Subscription;
use Yii;

class LogoutEventStrategy implements EventStrategyInterface
{
    public function notify($eventData)
    {
        // Извлекаем подписчиков, которые подписаны на событие "logout"
        $subscriptions = Subscription::find()->where(['event' => Subscription::EVENT_LOGOUT, 'is_block' => 0])->all();

        // Обходим список подписчиков и отправляем им письма
        foreach ($subscriptions as $subscription) {
            $body = "Dear subscriber, user ID " . $eventData['userId'] . " is logged out.";

            Yii::$app->mailer->compose()
                ->setTo($subscription->recipient)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Notification'])
                ->setSubject('Event "Logout"')
                ->setTextBody($body)
                ->send();
        }
    }
}
