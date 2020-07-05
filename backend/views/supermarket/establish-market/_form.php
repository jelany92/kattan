<?php

use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EstablishMarket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="establish-market-form">

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'selected_date')->widget(DatePicker::class, [
        'options'       => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
            'autoclose'    => true,
            'showMeridian' => false,
            'endDate'      => '+0d',
            'format'       => 'yyyy-mm-dd'
            //'format'       => 'dd.mm.yyyy'
        ],
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
