<?php


use backend\models\Capital;
use backend\models\IncomingRevenue;
use backend\models\MarketExpense;
use backend\models\Purchases;
use yii\bootstrap4\Html;
use common\widgets\Table;

/* @var $this yii\web\View */
/* @var $showCreate boolean */

$monthName = [
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

$this->title                   = $date;
$this->params['breadcrumbs'][] = $this->title;
$year                          = date("Y");
$amountCash                    = IncomingRevenue::sumResultIncomingRevenue()['result'] + Capital::sumResultCapital();
$amountPurchases               = Purchases::sumResultPurchases()['result'];
$amountExpense                 = MarketExpense::sumResultMarketExpense()['result'];
$resultCash                    = $amountCash - $amountPurchases - $amountExpense;
$totalIncomeOfTheShop          = IncomingRevenue::sumResultIncomingRevenue()['result'];

?>
<p>
    <?php if ($showCreateIncomingRevenue): ?>
        <?= Html::a(Yii::t('app', 'Incoming Revenue'), ['incoming-revenue/create'], [
            'class' => 'btn btn-success',
            'data'  => [
                'method' => 'post',
                'params' => ['date' => $date],
            ],
        ]) ?>
    <?php endif; ?>
    <?= Html::a(Yii::t('app', 'Purchases'), ['purchases/create'], [
        'class' => 'btn btn-success',
        'data'  => [
            'method' => 'post',
            'params' => ['date' => $date],
        ],
    ]) ?>
    <?= Html::a(Yii::t('app', 'Market Expense'), ['market-expense/create'], [
        'class' => 'btn btn-success',
        'data'  => [
            'method' => 'post',
            'params' => ['date' => $date],
        ],
    ]) ?>
    <?= Table::widget([
        'tableArray' => [
            [
                [
                    'type' => 'th',
                    'html' => '<strong>السبب</strong>',
                ],
                [
                    'type' => 'th',
                    'html' => '<strong>المبلغ</strong>',
                ],
            ],
            [
                [
                    'type' => 'td',
                    'html' => Yii::t('app', 'المجموع الكلي'),
                ],
                [
                    'type' => 'td',
                    'html' => $amountCash,
                ],
            ],
            [
                [
                    'type' => 'td',
                    'html' => Yii::t('app', 'مجموع الدخل اليومي'),
                ],
                [
                    'type' => 'td',
                    'html' => $totalIncomeOfTheShop,
                ],
            ],
            [
                [
                    'type' => 'td',
                    'html' => Yii::t('app', 'شراء بضاعة'),
                ],
                [
                    'type' => 'td',
                    'html' => $amountPurchases,
                ],
            ],
            [
                [
                    'type' => 'td',
                    'html' => Html::a(Html::encode(Yii::t('app', 'مصاريف المحل')), Yii::$app->urlManager->createUrl(['/market-expense/index'])),
                ],
                [
                    'type' => 'td',
                    'html' => Html::a(Html::encode($amountExpense), Yii::$app->urlManager->createUrl(['/market-expense/index'])),
                ],
            ],
            [
                [
                    'type' => 'td',
                    'html' => Yii::t('app', 'الباقي سيولة'),
                ],
                [
                    'type' => 'td',
                    'html' => $resultCash,
                ],
            ],
        ],
    ]); ?>

    <?php
    echo '<h1>Statistiken Für ganze Monat</h1>';
    for ($m = 1; $m <= 12; $m++)
    {
        $monthName = date('F', mktime(0, 0, 0, $m, 1)) . '<br>';
        echo Html::a(Yii::t('app', $monthName), ['site/month-view' . '?year=' . $year . '&month=' . $m], [
            '',
            'class' => 'btn btn-primary',
        ]);
    }
    echo '<h1>Statistiken Für Quartal</h1>';
    for ($i = 1; $i <= 4; $i++)
    {
        echo Html::a(Yii::t('app', $i), ['arbeitszeit/quartal-ansicht' . '?year=' . $year . '&quartal=' . $i], [
            '',
            'class' => 'btn btn-primary',
        ]);

    }
    echo '<h1>Statistiken Für Jahr</h1>';

    for ($i = 2019; $i <= 2030; $i++)
    {
        echo Html::a(Yii::t('app', $i), ['site/year-view' . '?year=' . $i], [
            '',
            'class' => 'btn btn-primary',
        ]);
    }
    ?>
</p>

