<?php

use common\modules\SubscriptionModule\models\Subscription;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\modules\SubscriptionModule\models\SubscriptionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Subscriptions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Subscription', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'enableSorting' => false,
               'filter' => false
            ],
            [
                'attribute' => 'event',
                'enableSorting' => false,
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'event',
                    Subscription::eventTypes(),
                    [
                        'class' => 'form-control',
                        'prompt' => '- - -'
                    ]
                ),
            ],
            [
                'attribute' => 'recipient',
                'format' => 'ntext',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'is_block',
                'enableSorting' => false,
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'is_block',
                    [0 => 'No', 1 => 'Yes'],
                    [
                        'class' => 'form-control',
                        'prompt' => '- - -'
                    ]
                ),
            ],
            [
                'class' => \yii\grid\ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return \yii\helpers\Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update}', // здесь определяется, какие кнопки будут отображаться
            ],
        ],
    ]); ?>


</div>
