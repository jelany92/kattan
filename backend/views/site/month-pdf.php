<?php

use common\components\GridView;
use common\components\QueryHelper;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $statistikMonatProvider ArrayDataProvider */
/* @var $modelIncomingRevenue ArrayDataProvider */
/* @var $modelPurchases ArrayDataProvider */
/* @var $dataProviderMarketExpense ArrayDataProvider */

$monthName   = [
    '',
    'Januar',
    'Februar',
    'März',
    'April',
    'Mai',
    'Juni',
    'Juli',
    'August',
    'September',
    'Oktober',
    'November',
    'Dezember',
];
$this->title = Yii::t('app', $monthName[$month]);

$ein       = QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue');
$aus       = QueryHelper::getMonthData($year, $month, 'purchases', 'purchases');
$ausMarket = QueryHelper::getMonthData($year, $month, 'market_expense', 'expense');
$result    = $ein - $aus - $ausMarket;
?>

<div class="Monat Ansicht-index">
    <div class="col-sm-4">
        <h1>
            <?= Yii::t('app', 'الايراد اليومي: ') . $ein?>
        </h1>
        <?= GridView::widget([
            'dataProvider' => $modelIncomingRevenue,
            'columns'      => [
                [
                    'class' => 'yii\grid\SerialColumn',
                ],
                'date',
                'total',
            ],
        ]) ?>
    </div>
    <div class="col-sm-4">
        <h1>
            <?= Yii::t('app', 'شراء بضائع: ') . $aus?>
        </h1>
        <?= GridView::widget([
            'dataProvider' => $modelPurchases,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                'date',
                'total',
                'reason',
            ],
        ]) ?>
    </div>
    <div class="col-sm-4">
        <h1>
            <?= Yii::t('app', 'مصاريف للمحل: ') . $ausMarket?>
        </h1>
        <?= GridView::widget([
            'dataProvider' => $dataProviderMarketExpense,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                'date',
                'total',
                'reason',
            ],
        ]) ?>
    </div>
</div>
