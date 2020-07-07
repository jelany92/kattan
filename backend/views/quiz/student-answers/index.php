<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\quiz\search\StudentAnswersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Student Answers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-answers-crud-index">

    <?php if (Yii::$app->user->can('admin')) : ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
                                 'dataProvider' => $dataProvider,
                                 'filterModel'  => $searchModel,
                                 'columns'      => [
                                     ['class' => 'yii\grid\SerialColumn'],

                                     [
                                         'attribute' => 'excercise_id',
                                         'label'     => 'Excercise ID',
                                         'value'     => function ($model) {
                                             return $model->excercise->id;
                                         },
                                     ],
                                     [
                                         'attribute' => 'student_id',
                                         'label'     => 'Student Name',
                                         'value'     => function ($model) {
                                             return $model->student->name;
                                         },
                                     ],
                                     'student_answer',
                                     'created_at',
                                     'updated_at',
                                 ],
                             ]); ?>
        <?php Pjax::end(); ?>
    <?php endif; ?>
</div>
