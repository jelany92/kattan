<?php

use common\components\QueryHelper;
use common\widgets\Table;

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

$tableArray['tableArray'] = [
    [
        [
            'type'    => 'td',
            'colspan' => 2,
            'html'    => '<strong>Legende</strong>',
        ],
    ],
    [
        [
            'type'    => 'td',
            'colspan' => 2,
            'html'    => '<strong>Legende</strong>',
        ],
    ],
    [
        [
            'type'    => 'td',
            'colspan' => 2,
            'html'    => '<strong>Legende</strong>',
        ],
    ],
];

foreach ($dataProviderMarketExpense as $marketExpense)
{
    $tableArray['tableArray'] = [
        [
            [
                'type'    => 'td',
                'colspan' => 2,
                'html'    => $marketExpense['total'],
            ],
        ],
        [
            [
                'type'    => 'td',
                'colspan' => 2,
                'html'    => $marketExpense['date'],
            ],
        ],
        [
            [
                'type'    => 'td',
                'colspan' => 2,
                'html'    => $marketExpense['reason'],
            ],
        ],
    ];
}
?>

<?= Yii::t('app', 'الايراد اليومي: ') . $ein ?>

<?= Table::widget($tableArray); ?>


