<?php

use common\modules\SubscriptionModule\models\Subscription;
use kartik\date\DatePicker;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

use common\modules\SubscriptionModule\assets\SubscriptionModuleAsset;

SubscriptionModuleAsset::register($this);

/** @var yii\web\View $this */
/** @var common\modules\SubscriptionModule\models\Subscription $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="subscription-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event')->dropDownList(Subscription::eventTypes(),  ['prompt' => '- - -']) ?>

    <?= $form->field($model, 'recipient')->textInput() ?>

    <?= $form->field($model, 'is_block')->dropDownList(
        [0 => 'Нет', 1 => 'Да'],
        ['options' => [0 => ['Selected' => true]]]
    ) ?>

    <?= $form->field($model, 'created_at')->textInput([
        'class' => 'form-control datetimepicker',
        'value' => Yii::$app->formatter->asDatetime($model->created_at, "php:Y-m-d H:i")
    ]); ?>


    <?= $form->field($model, 'updated_at')->textInput([
        'class' => 'form-control datetimepicker',
        'value' => Yii::$app->formatter->asDatetime($model->updated_at, "php:Y-m-d H:i")
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$js = <<<JS
$('.datetimepicker').datetimepicker({
  format:'Y-m-d H:i'
});
JS;

// Регистрируем inline скрипт
$this->registerJs($js, \yii\web\View::POS_READY);
?>