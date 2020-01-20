<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\ArticlePrice */
/* @var $form yii\widgets\ActiveForm */
/* @var $articleList array */
?>

<div class="article-price-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'article_info_id')->dropDownList($articleList) ?>

    <?= $form->field($model, 'article_total_prise')->textInput() ?>

    <?= $form->field($model, 'article_count')->textInput() ?>

    <?= $form->field($model, 'seller_name')->textInput(['maxlength' => true]) ?>

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
