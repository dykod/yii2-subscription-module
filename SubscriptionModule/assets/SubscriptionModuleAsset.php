<?php
namespace common\modules\SubscriptionModule\assets;

use yii\web\AssetBundle;

class SubscriptionModuleAsset extends AssetBundle
{
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        //
    ];
}
