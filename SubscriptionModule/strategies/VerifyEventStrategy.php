<?php

namespace common\modules\SubscriptionModule\strategies;

use common\modules\SubscriptionModule\models\Subscription;
use Yii;

class VerifyEventStrategy implements EventStrategyInterface
{
    public function notify($eventData)
    {
        $subscriptions = Subscription::find()->where(['event' => Subscription::EVENT_VERIFY, 'is_block' => 0])->all();

        // Обходим список подписчиков и отправляем им письма
        foreach ($subscriptions as $subscription) {
            $body = "Dear subscriber, user ID " . $eventData['userId'] . " has passed verification.";

            Yii::$app->mailer->compose()
                ->setTo($subscription->recipient)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Notification'])
                ->setSubject('Event "Verify"')
                ->setTextBody($body)
                ->send();
        }
    }
}