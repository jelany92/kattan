<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\quiz\search\ExcerciseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="excercise-crud-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin([
                          'id'              => 'pjax-students-gridview',
                          'timeout'         => false,
                          'enablePushState' => false,
                      ]);; ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Excercise'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'question:ntext',
                                 'answer_a',
                                 'answer_b',
                                 'answer_c',
                                 'answer_d',
                                 'correct_answer',

                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>
    <?php Pjax::end(); ?>
</div>
