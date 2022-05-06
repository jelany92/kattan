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
                             'options'      => [
                                 'id'    => 'permission_grid',
                                 'style' => 'overflow: auto; word-wrap: break-word;',
                             ],
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
                                 [
                                     'attribute'      => 'answer_a',
                                     'contentOptions' => function($model)
                                     {
                                        if (!empty($model->correct_answer) &&  $model->answer_a === $model[$model->correct_answer])
                                        {
                                            return ['style' =>'background: yellow;'];
                                        }
                                         return ['style' => ''];
                                     }
                                 ],
                                 [
                                     'attribute'      => 'answer_b',
                                     'contentOptions' => function($model)
                                     {
                                         if (!empty($model->correct_answer) &&  $model->answer_b === $model[$model->correct_answer])
                                         {
                                             return ['style' =>'background: yellow;'];
                                         }
                                         return ['style' => ''];
                                     }
                                 ],
                                 [
                                     'attribute'      => 'answer_c',
                                     'contentOptions' => function($model)
                                     {
                                         if (!empty($model->correct_answer) &&  $model->answer_c === $model[$model->correct_answer])
                                         {
                                             return ['style' =>'background: yellow;'];
                                         }
                                         return ['style' => ''];
                                     }
                                 ],
                                 [
                                     'attribute'      => 'answer_d',
                                     'contentOptions' => function($model)
                                     {
                                         if (!empty($model->correct_answer) &&  $model->answer_d === $model[$model->correct_answer])
                                         {
                                             return ['style' =>'background: yellow;'];
                                         }
                                         return ['style' => ''];
                                     }
                                 ],
                                 [
                                     'attribute' => 'correct_answer',
                                     'value'     => function ($model) {
                                         if (!empty($model->correct_answer))
                                         {
                                             return $model[$model->correct_answer];
                                         }
                                     },
                                 ],

                                 ['class' => 'common\components\ActionColumn'],
                             ],
                         ]); ?>
    <?php Pjax::end(); ?>
</div>
