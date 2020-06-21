<?php

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\learn\LearnStaff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="learn-staff-form">

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]) ?>
    <?= $form->field($model, 'staff_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
