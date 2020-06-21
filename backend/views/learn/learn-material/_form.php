<?php

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use backend\models\learn\LearnStaff;

/* @var $this yii\web\View */
/* @var $model backend\models\learn\LearnMaterial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="learn-material-form">

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]) ?>

    <?= $form->field($model, 'learn_staff_id', [])->widget(Select2::class, [
        'model'         => $model,
        'attribute'     => 'learn_staff_id',
        'options'       => [
            'placeholder' => 'please Choose ...',
            //'multiple'    => true,
        ],
        'pluginOptions' => [
            'allowClear'         => true,
            'maximumInputLength' => false,
        ],
        'size'          => Select2::LARGE,
        'data'          => LearnStaff::getStaffList(),
    ]) ?>

    <?= $form->field($model, 'material_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'material_link')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
