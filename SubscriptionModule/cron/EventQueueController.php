<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\modules\SubscriptionModule\components\FileLock;
use common\modules\SubscriptionModule\services\EventQueueService;

class EventQueueController extends Controller
{
    public function actionProcess()
    {
        $lockFile = Yii::getAlias('@app/runtime') . '/process_event_queue.lock';
        $fileLock = new FileLock($lockFile);
        if ($fileLock->lock()) {
            $eventQueueService = new EventQueueService();
            $eventQueueService->processEvents();

            $fileLock->unlock();
        } else {
            echo "Another instance of the script is already running.\n";
        }
        echo "Done.\n";
    }
}

#php yii event-queue/process
