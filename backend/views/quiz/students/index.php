<?php

use yii\bootstrap4\Html;
use common\components\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Students');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="students-crud-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Students'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'token',
            [
                'attribute' => 'name',
                'label' => 'Name',
                'format' => 'html',
                'value' => function($model){
                    return Html::a($model->name, ['/quiz/token/quiz-result', 'studentId' => $model->id]);
                }
            ],
            'correct_answer',
            'wrong_answer',
            'score',
            [
                'attribute' => 'is_complete',
                'label' => 'Is Completed',
                'value' => function($model){
                    return $model->is_complete ? 'Completed' : 'Pending';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
