<?php

namespace common\modules\SubscriptionModule\tests\unit;

use common\modules\SubscriptionModule\models\Subscription;
use common\modules\SubscriptionModule\services\EventQueueService;
use Yii;

class SubscriptionTest extends \Codeception\Test\Unit
{
    protected $eventQueueService;

    protected function setUp(): void
    {
        Yii::$app->params['adminEmail'] = 'admin@test.ru';
        // Инициализируем сервис очереди событий
        $this->eventQueueService = new EventQueueService();

        $events = [
            Subscription::EVENT_REG,
            Subscription::EVENT_LOGIN,
            Subscription::EVENT_VERIFY,
            Subscription::EVENT_MESSAGE,
            Subscription::EVENT_LOGOUT,
        ];

        $stamp = date("Y-m-d H:i:s", time());
        foreach ($events as $i => $event) {
            $id = $i+1;
            $subscription = new Subscription([
                'event' => $event,
                'recipient' => 'user' . $id . '@example.com',
                'is_block' => 0,
                'created_at' => $stamp,
                'updated_at' => $stamp,
            ]);
            $subscription->save(false);

            // Помещаем событие в Redis
            $this->eventQueueService->enqueueEvent($event, $id);
        }

        $id++;
        // Дополнительный юзер reg
        $subscription = new Subscription([
            'event' => Subscription::EVENT_REG,
            'recipient' => 'user' . $id . '@example.com',
            'is_block' => 0,
            'created_at' => $stamp,
            'updated_at' => $stamp,
        ]);
        $subscription->save(false);
        $this->eventQueueService->enqueueEvent(Subscription::EVENT_REG, $id);

        // Добавляем дополнительного юзера с is_block=1
        $blockedSubscription = new Subscription([
            'event' => Subscription::EVENT_LOGIN,
            'recipient' => 'blocked_user@example.com',
            'is_block' => 1,
            'created_at' => $stamp,
            'updated_at' => $stamp,
        ]);
        $blockedSubscription->save(false);
    }

    public function testEventsCount()
    {
        // Вызываем обработчик событий
        //$this->eventQueueService->processEvents();
        $countTotal = 0;
        $types = [];
        $eventData = $this->eventQueueService->dequeueEvent();
        while ($eventData) {
            $countTotal++;
            if (isset($types[$eventData["type"]])) {
                $types[$eventData["type"]]++;
            }else{
                $types[$eventData["type"]]=1;
            }
            //$eventStrategy = EventStrategyFactory::create($eventData['type']);
            //$eventStrategy->notify($eventData);
            $eventData = $this->eventQueueService->dequeueEvent();
        }

        $this->assertEquals(6, $countTotal, "Expected 6, found " . $countTotal);
        $this->assertEquals(2, $types[Subscription::EVENT_REG], "Expected 2, found " . $types[Subscription::EVENT_REG]);
        $this->assertEquals(5, count($types), "Expected 5, found " . count($types));
    }
}
#/var/www/sub.local/sub/common$ ../vendor/bin/codecept run unit modules/SubscriptionModule/tests/unit/SubscriptionTest --debug