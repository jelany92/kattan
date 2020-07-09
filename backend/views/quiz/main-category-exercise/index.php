<?php

use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\quiz\search\MainCategoryExerciseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Main Category Exercises');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-category-exercise-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Main Category Exercise'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],

                                 [
                                     'attribute' => 'main_category_exercise_name',
                                     'value'     => function ($model) {
                                         return Html::a($model->main_category_exercise_name, [
                                             'quiz/excercise/create',
                                             'mainCategoryExerciseId' => $model->id,
                                         ]);
                                     },
                                     'format'    => 'raw',
                                 ],
                                 'description:ntext',
                                 'question_type:ntext',

                                 ['class' => 'common\components\ActionColumn'],
                             ],
                         ]); ?>


</div>
