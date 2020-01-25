<?php

use common\models\Article;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList($articleList) ?>

    <?= $form->field($model, 'article_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'article_photo')->widget(FileInput::class, [
        'options'       => ['accept' => 'image/*'],
        'pluginOptions' => [
            'maxFileCount'         => 1,
            'initialPreviewAsData' => true,
            'showUpload'           => false,
            'initialCaption'       => Yii::t('app', 'Datei auswählen'),
            'browseLabel'          => Yii::t('app', 'Auswählen'),
            'removeLabel'          => Yii::t('app', 'Löschen'),
        ],
    ]); ?>

    <?= $form->field($model, 'article_unit')->dropDownList(Article::UNIT_LIST) ?>

        <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
