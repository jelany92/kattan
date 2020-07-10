<?php

use yii\bootstrap4\Html;
use common\components\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\quiz\search\ExcerciseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Question')
?>
<div class="excercise-crud-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin([
                          'id'              => 'pjax-students-gridview',
                          'timeout'         => false,
                          'enablePushState' => false,
                      ]);; ?>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 [
                                     'attribute' => 'main_category_exercise_name',
                                     'value'     => function ($model) {
                                         return Html::a($model->mainCategoryExercise->main_category_exercise_name, [
                                             'quiz/excercise/create',
                                             'mainCategoryExerciseId' => $model->id,
                                         ]);
                                     },
                                     'format'    => 'raw',
                                 ],
                                 'question:ntext',
                                 'answer_a',
                                 'answer_b',
                                 'answer_c',
                                 'answer_d',
                                 [
                                     'attribute' => 'correct_answer',
                                     'value'     => function ($model) {
                                         return $model[$model->correct_answer];
                                     },
                                 ],

                                 ['class' => 'common\components\ActionColumn'],
                             ],
                         ]); ?>
    <?php Pjax::end(); ?>
</div>
