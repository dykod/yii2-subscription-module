<?php

namespace common\modules\SubscriptionModule;

use app\models\User;
use yii\base\Event;

/**
 * subscription module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\SubscriptionModule\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
