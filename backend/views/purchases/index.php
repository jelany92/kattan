<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Purchases;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\PurchasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Purchases');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchases-index">

    <h1><?= Html::encode($this->title) . ': ' . Purchases::sumResultPurchases()['result'] ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Purchases'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', Yii::t('app', 'Purchases export')), [
            'purchases/export',
        ], ['class' => 'btn btn-success']) ?>    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'reason',
            'purchases',
            'selected_date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
