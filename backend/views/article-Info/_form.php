<?php

use common\models\ArticleInfo;
use kartik\file\FileInput;
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList($articleList) ?>

    <?= $form->field($model, 'article_name_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'article_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'article_quantity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'article_unit')->dropDownList(ArticleInfo::UNIT_LIST) ?>

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
