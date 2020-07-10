<?php

use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\quiz\search\ExcerciseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Your Answer')
?>
<div class="excercise-crud-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 [
                                     'attribute' => 'excercise_id',
                                     'value'     => 'excercise.question',
                                 ],
                                 [
                                     'attribute' => 'student_id',
                                     'value'     => 'student.name',
                                 ],
                                 [
                                     'attribute' => 'student_answer',
                                     'value'     => function ($model) {
                                         return $model->excercise->answer_a;
                                         //var_dump($model->excercise);die();
                                     },
                                 ],
                                 [
                                     'attribute' => 'student_answer',
                                     'value'     => function ($model) {
                                         return $model->excercise[$model->student_answer];
                                     },
                                 ],
                                 [
                                     'label' => Yii::t('app', 'Correct Answer'),
                                     'value' => function ($model) {
                                         return $model->excercise[$model->excercise->correct_answer];
                                     },
                                 ],
                             ],
                         ]); ?>
</div>
