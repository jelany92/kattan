<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use backend\models\IncomingRevenue;
use yii2tech\spreadsheet\Spreadsheet;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\IncomingRevenueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Incoming Revenues');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-revenue-index">

    <h1><?= Html::encode($this->title) . ': ' . IncomingRevenue::sumResultIncomingRevenue()['result'] ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Incoming Revenue'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', Yii::t('app', 'Incoming export')), [
            'incoming-revenue/export',
        ], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'daily_incoming_revenue',
            'selected_date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
