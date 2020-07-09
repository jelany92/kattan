<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\quiz\MainCategoryExercise */

$this->title = Yii::t('app', 'Create Main Category Exercise');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Main Category Exercises'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-category-exercise-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
