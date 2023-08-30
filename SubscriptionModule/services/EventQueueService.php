<?php
namespace common\modules\SubscriptionModule\services;

use common\modules\SubscriptionModule\strategies\EventStrategyFactory;
use Predis\Client;

class EventQueueService
{
    private $redis;

    public function __construct()
    {
        // Инициализация клиента Redis
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);
    }

    public function enqueueEvent($type, $userId)
    {
        $eventData = json_encode([
            'type' => $type,
            'userId' => $userId
        ]);

        // Добавляем событие в очередь в Redis
        $this->redis->rpush('eventQueue', $eventData);
    }

    public function dequeueEvent()
    {
        // Извлекаем событие из очереди в Redis
        $eventData = $this->redis->lpop('eventQueue');

        if ($eventData) {
            return json_decode($eventData, true);
        }

        // Возвращаем null, если очереди пуста
        return null;
    }

    public function processEvents()
    {
        $eventData = $this->dequeueEvent();
        while ($eventData) {
            $eventStrategy = EventStrategyFactory::create($eventData['type']);
            $eventStrategy->notify($eventData);
            $eventData = $this->dequeueEvent();
        }
    }
}

