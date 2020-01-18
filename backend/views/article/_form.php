<?php

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use common\models\Article;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
/* @var $articleList array */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]) ?>
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

    <?= $form->field($model, 'article_count')->textInput() ?>

    <?= $form->field($model, 'article_total_prise')->textInput() ?>

    <?= $form->field($model, 'article_unit')->dropDownList(Article::UNIT_LIST) ?>

    <?= $form->field($model, 'status')->dropDownList(Article::STATUS) ?>

    <?= $form->field($model, 'seller_name')->textInput() ?>

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
