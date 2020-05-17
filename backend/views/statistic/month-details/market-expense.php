<?php

use common\components\QueryHelper;
use yii\bootstrap4\Html;
use common\components\GridView;
use onmotion\apexcharts\ApexchartsWidget;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $dataProviderMarketExpense ArrayDataProvider */
/* @var $staticDailyInfoMarketExpenseList array */

$monthName                     = [
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
$this->title                   = Yii::t('app', $monthName[$month]);
$this->params['breadcrumbs'][] = $this->title;

$ausMarket = QueryHelper::getMonthData($year, $month, 'market_expense', 'expense');

$expense   = [];
// market expo
foreach ($staticDailyInfoMarketExpenseList as $dailyInfoMarketExpense)
{
    $expense[] = [
        $dailyInfoMarketExpense['date'],
        $dailyInfoMarketExpense['total'],
    ];
}
$series = [
    [
        'name' => Yii::t('app', 'احصائيات نفقات المحل'),
        'data' => $expense,
    ],
];
?>

<?= $this->render('/site/supermarket/_sub_navigation',[
    'year'  => $year,
    'month' => $month,
]) ?>

<?= ApexchartsWidget::widget([
                                 'type'         => 'bar',
                                 // default area
                                 'height'       => '400',
                                 // default 350
                                 'width'        => '100%',
                                 // default 100%
                                 'chartOptions' => [
                                     'chart'       => [
                                         'toolbar' => [
                                             'show'         => true,
                                             'autoSelected' => 'zoom',
                                         ],
                                     ],
                                     'xaxis'       => [
                                         'type' => 'datetime',
                                         // 'categories' => $categories,
                                     ],
                                     'plotOptions' => [
                                         'bar' => [
                                             'horizontal'  => false,
                                             'endingShape' => 'flat',
                                         ],
                                     ],
                                     'dataLabels'  => [
                                         'enabled' => false,
                                     ],
                                     'stroke'      => [
                                         'show'   => true,
                                         'colors' => ['transparent'],
                                     ],
                                     'legend'      => [
                                         'verticalAlign'   => 'bottom',
                                         'horizontalAlign' => 'left',
                                     ],
                                 ],
                                 'series'       => $series,
                             ]); ?>

<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <h1>
                <?= $ausMarket ?>
                <?= Yii::t('app', 'نفقات المحل') ?>
                <?= Html::a(Yii::t('app', 'All Ausgeben'), ['purchases/index'], ['class' => 'btn btn-success']) ?>
            </h1>
            <?= GridView::widget([
                'dataProvider' => $dataProviderMarketExpense,
                'columns'      => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'total',
                    'reason',
                    'date',
                ],
            ]) ?>
        </div>
    </div>
</div>


