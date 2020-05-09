<?php

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
/* @var $fileUrls string */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]) ?>
    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'file')->widget(FileInput::class, [
        'options'       => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialPreview'       => ($fileUrls) ? $fileUrls : [],
            'maxFileCount'         => 1,
            'showUpload'           => false,
            'initialPreviewAsData' => true,
            'overwriteInitial'     => false,
            //'deleteUrl'            => Yii::$app->urlManager->createUrl('/purchase-invoices/delete-file'),
            'initialCaption'       => Yii::t('app', 'Datei auswählen'),
            'browseLabel'          => Yii::t('app', 'Auswählen'),
            'removeLabel'          => Yii::t('app', 'Löschen'),
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
