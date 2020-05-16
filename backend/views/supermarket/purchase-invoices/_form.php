<?php

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use kartik\file\FileInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseInvoices */
/* @var $form yii\widgets\ActiveForm */
/* @var $fileUrls array */
/* @var $invoiceFileList array */

?>

<div class="purchase-invoices-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]) ?>

    <?= $form->field($model, 'seller_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file[]')->widget(FileInput::class, [
        'options'       => [
            'id'       => 'file',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'initialPreview'       => ($fileUrls) ? $fileUrls : [],
            'showUpload'           => false,
            'initialPreviewAsData' => true,
            'initialPreviewConfig' => $invoiceFileList,
            'overwriteInitial'     => false,
            'deleteUrl'            => Yii::$app->urlManager->createUrl('/purchase-invoices/delete-file'),
            'maxFileCount'         => false,
            'initialCaption'       => Yii::t('app', 'Datei auswählen'),
            'browseLabel'          => Yii::t('app', 'Auswählen'),
            'removeLabel'          => Yii::t('app', 'Löschen'),
        ],
        'pluginEvents'  => [
            'filepredelete' => "function(event, key) { return (!confirm('" . Yii::t('app', 'Sind Sie sicher, dass Sie den Anhang löschen möchten?') . "')); }",
        ],
    ]); ?>

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
