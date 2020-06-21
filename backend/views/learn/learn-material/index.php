<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\learn\searchModel\LearnMaterial */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Learn Materials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learn-material-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Learn Material'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                                     'attribute' => 'learn_staff_id',
                                     'value'     => function ($model) {
                                         return $model->learnStaff->staff_name;
                                     },
                                     'format'    => 'raw',
                                 ],
                                 'material_name',
                                 'material_link:url',
                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>


</div>
