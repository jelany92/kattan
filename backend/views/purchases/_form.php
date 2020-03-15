<?php

use yii\bootstrap4\Html;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Purchases */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchases-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]) ?>
    <?= $form->field($model, 'purchases')->textInput() ?>

    <?= $form->field($model, 'reason')->textInput() ?>

    <?= $form->field($model, 'selected_date')->widget(DatePicker::class, [
        'options' => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
            'autoclose'    => true,
            'showMeridian' => false,
            'endDate'      => '+0d',
            'format'       => 'yyyy-mm-dd'
            //'format'       => 'dd.mm.yyyy'
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
