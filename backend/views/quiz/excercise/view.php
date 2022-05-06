<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \backend\models\quiz\Excercise */

$this->title = 'Excercise ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Main Category Exercises'), 'url' => ['quiz/main-category-exercise']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Excercise'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="excercise-crud-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mainCategoryExercise.main_category_exercise_name',
            'question:ntext',
            [
                'attribute'      => 'answer_a',
                'contentOptions' => ['style' => $model->answer_a === $model[$model->correct_answer] ?'background: yellow;': ''],
            ],
            [
                'attribute'      => 'answer_b',
                'contentOptions' => ['style' => $model->answer_b === $model[$model->correct_answer] ?'background: yellow;': ''],
            ],
            [
                'attribute'      => 'answer_c',
                'contentOptions' => ['style' => $model->answer_c === $model[$model->correct_answer] ?'background: yellow;': ''],
            ],
            [
                'attribute'      => 'answer_d',
                'contentOptions' => ['style' => $model->answer_d === $model[$model->correct_answer] ?'background: yellow;': ''],
            ],
            [
                'attribute' => 'correct_answer',
                'value' => function ($model) {
                    if (!empty($model->correct_answer)) {
                        return $model[$model->correct_answer];
                    }
                },
            ],],
    ]) ?>

</div>
