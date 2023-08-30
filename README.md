# Модуль подписки на события системы.


![yii2 framework](/yii3.png)

## Описание

События могут быть вызваны из любого места системы.
Подписчикам события отправляется email с детализацией события

## Установка
1. Выгрузить в common/modules
2. Выполнить миграцию

```bash
php yii migrate --migrationPath=common/modules/SubscriptionModule/migrations
```

3. В файле конфигурации frontend/config/main.php добавить
```bash
   'modules' => [
      'subscription' => [
        'class' => 'common\modules\SubscriptionModule\Module',
      ],
   ],
```

4. Модуль будет доступен по адресу
```bash
http://your_application_url/subscription/subscription/index
```

5. Установить сервер redis и запустить его
```bash
sudo apt update
sudo apt install redis-server
sudo service redis-server start
```

6. Установить в проект библиотеку
```bash
composer require predis/predis
```

7. В файле конфигурации frontend/config/main.php добавить
```bash
    'components' => [
        'eventQueue' => [
            'class' => 'common\modules\SubscriptionModule\services\EventQueueService',
        ],
```

8. Скопировать файл
```bash
SubscriptionModule/cron/EventQueueController.php --> /console/controllers
```

## Использование

1. Генерация событий
```bash
Yii::$app->eventQueue->enqueueEvent(Subscription::EVENT_VERIFY, $userIdWhoTriggeredEvent);
```

2. Для обработки событий нужно повесить на крон каждую минуту вызов:
```bash
php yii event-queue/process
```

## Тестирование
1. Запуск теста из директории common
```bash
path/to/common$ ../vendor/bin/codecept run unit modules/SubscriptionModule/tests/unit/SubscriptionTest
```

## Скринкасты
1. [Демонстрация frontend](https://youtu.be/QIJt37E8O9Q).
2. [Демонстрация ручного теста](https://www.youtube.com/watch?v=ualugj0q7yU).
3. [Демонстрация unit теста](https://youtu.be/GQPVfzzc4Xk).