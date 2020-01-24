<?php

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use kartik\file\FileInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseInvoices */
/* @var $form yii\widgets\ActiveForm */
$logo = $model->getLogoThumbnailUrl();

?>

<div class="purchase-invoices-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]) ?>
    <?= $form->field($model, 'invoice_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoicePhoto')->widget(FileInput::class, [
        'options'       => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialPreview'       => ($logo) ? $logo : [],
            'maxFileCount'         => 1,
            'initialPreviewAsData' => true,
            'showUpload'           => false,
            'initialPreviewConfig' => [
                [
                    'url' => Yii::$app->urlManager->createUrl([
                        'user-stamm/delete-logo',
                        'id' => $model->id,
                    ]),
                ],
                // server delete action
            ],
            'initialCaption'       => Yii::t('app', 'Datei auswählen'),
            'browseLabel'          => Yii::t('app', 'Auswählen'),
            'removeLabel'          => Yii::t('app', 'Löschen'),
        ],
    ]); ?>

    <?= $form->field($model, 'seller_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

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
