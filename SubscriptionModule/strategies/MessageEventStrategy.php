<?php

namespace common\modules\SubscriptionModule\strategies;

use common\modules\SubscriptionModule\models\Subscription;
use Yii;

class MessageEventStrategy implements EventStrategyInterface
{
    public function notify($eventData)
    {
        $subscriptions = Subscription::find()->where(['event' => Subscription::EVENT_MESSAGE, 'is_block' => 0])->all();

        // Обходим список подписчиков и отправляем им письма
        foreach ($subscriptions as $subscription) {
            $body = "Dear subscriber, user ID " . $eventData['userId'] . " sent a message.";

            Yii::$app->mailer->compose()
                ->setTo($subscription->recipient)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Notification'])
                ->setSubject('Event "Message"')
                ->setTextBody($body)
                ->send();
        }
    }
}