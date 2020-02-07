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
/* @var $dataProviderDailyCash ArrayDataProvider */

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

<?= Yii::t('app', 'الايراد اليومي: ') . $ein ?>
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
<?= Yii::t('app', 'شراء بضائع: ') . $aus ?>
<?= GridView::widget([
    'dataProvider' => $modelPurchases,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        'date',
        'total',
        'reason',
    ],
]) ?>
<?= Yii::t('app', 'مصاريف للمحل: ') . $ausMarket ?>
<?= GridView::widget([
    'dataProvider' => $dataProviderMarketExpense,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        'date',
        'total',
        'reason',
    ],
]) ?>

<?= Yii::t('app', 'الدخل اليومي') ?>
<?= GridView::widget([
    'dataProvider' => $dataProviderDailyCash,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Count',
            'value' => function ($model) {
                return $model[0];
            },
        ],
        [
            'label' => 'Date',
            'value' => function ($model) {
                return $model[1];
            },
        ],
    ],
]) ?>


