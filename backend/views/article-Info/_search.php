<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\searchModel\ArticleInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'article_name') ?>

    <?= $form->field($model, 'article_photo') ?>

    <?= $form->field($model, 'article_count') ?>

    <?php // echo $form->field($model, 'article_unit') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'selected_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
