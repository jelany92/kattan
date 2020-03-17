<?php

use yii\bootstrap4\Html;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Purchases */
/* @var $form yii\widgets\ActiveForm */
/* @var $reasonList array */
?>

<div class="purchases-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]) ?>
    <?= $form->field($model, 'purchases')->textInput() ?>

    <?= $form->field($model, 'reason', [])->widget(Select2::class, [
        'model'         => $model,
        'attribute'     => 'reason',
        'options'       => [
            'placeholder' => 'Bitte auswählen ...',
        ],
        'pluginOptions' => [
            'allowClear'         => false,
            'tags'               => true,
            'maximumInputLength' => false,
        ],
        'data'          => $reasonList,
    ]) ?>

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
