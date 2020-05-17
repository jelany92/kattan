<?php

use common\components\QueryHelper;
use yii\bootstrap4\Html;
use common\components\GridView;
use common\widgets\Table;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $statistikMonatProvider ArrayDataProvider */
/* @var $modelIncomingRevenue ArrayDataProvider */
/* @var $modelPurchases ArrayDataProvider */
/* @var $dataProviderMarketExpense ArrayDataProvider */

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

$ein       = QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue');
$aus       = QueryHelper::getMonthData($year, $month, 'purchases', 'purchases');
$ausMarket = QueryHelper::getMonthData($year, $month, 'market_expense', 'expense');
$result    = $ein - $aus - $ausMarket;
?>

<div class="Monat Ansicht-index">
    <form method="post">
        <?php
        for ($m = 1; $m <= 12; $m++)
        {
            $monthName = date('F', mktime(0, 0, 0, $m, 1)) . '<br>';
            echo Html::a(Yii::t('app', $monthName), ['month-view' . '?year=' . $year . '&month=' . $m], [
                    '',
                    'class' => 'btn btn-primary',
                    'style' => $month == $m ? 'background-color: #40a7ff;' : '',
                ]) . ' ';
        }
        ?>
    </form>
    <h1>
        <?= Html::a('zurück', [
            'site/view',
            'date' => Yii::$app->session->get('returnDate'),
        ], [
            '',
            'class' => 'btn btn-success',
        ]); ?>

        <?= Html::a('PDF', [
            '/site/month-view-pdf',
            'year'  => $year,
            'month' => $month,
            'view'  => 'month-pdf',
        ], [
            'class'       => 'btn btn-danger',
            'target'      => '_blank',
            'data-toggle' => 'tooltip',
            'title'       => 'Will open the generated PDF file in a new window',
        ]) ?>
        </br>
    </h1>
    <?= $this->render('_sub_navigation',[
        'year'  => $year,
        'month' => $month,
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
                    'html' => Yii::t('app', 'مجموع الدخل للشهر') . ' ' . $this->title,
                ],
                [
                    'type' => 'td',
                    'html' => $ein,
                ],
            ],
            [
                [
                    'type' => 'td',
                    'html' => Yii::t('app', 'مجموع المصاريف للشهر') . ' ' . $this->title,
                ],
                [
                    'type' => 'td',
                    'html' => $aus,
                ],
            ],
            [
                [
                    'type' => 'td',
                    'html' => Yii::t('app', 'مجموع المصاريف الماركت للشهر') . ' ' . $this->title,
                ],
                [
                    'type' => 'td',
                    'html' => $ausMarket,
                ],
            ],
            [
                [
                    'type' => 'td',
                    'html' => Yii::t('app', 'الباقي كاش'),
                ],
                [
                    'type' => 'td',
                    'html' => $result,
                ],
            ],
        ],
    ]); ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>
                    <?= $ein ?>
                    <?= Yii::t('app', 'تفاصيل الدخل') ?>
                    <?= Html::a(Yii::t('app', 'All Einkommen'), ['incoming-revenue/index'], ['class' => 'btn btn-success']) ?>
                </h1>
                <?= GridView::widget([
                    'dataProvider' => $modelIncomingRevenue,
                    'columns'      => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'date',
                        'total',
                    ],
                ]) ?>
            </div>
            <div class="col-sm-6">
                <h1>
                    <?= $aus ?>
                    <?= Yii::t('app', 'تفاصيل المدفوعات شراء بضاعة') ?>
                    <?= Html::a(Yii::t('app', 'All Ausgeben'), ['purchases/index'], ['class' => 'btn btn-success']) ?>
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
            <div class="col-sm-6">
                <h1>
                    <?= $ausMarket ?>
                    <?= Yii::t('app', 'تفاصيل المدفوعات للمحل') ?>
                    <?= Html::a(Yii::t('app', 'All Ausgeben'), ['purchases/index'], ['class' => 'btn btn-success']) ?>
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
            <div class="col-sm-6">
                <h1>
                    <?= $result ?>
                    <?= Yii::t('app', 'الرصيد اليومي') ?>
                    <?= Html::a(Yii::t('app', 'All Einkommen'), ['incoming-revenue/index'], ['class' => 'btn btn-success']) ?>
                </h1>
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
            </div>
            <div class="col-sm-6">
                <h1>
                    <?= $ausMarket ?>
                    <?= Yii::t('app', ': مدفوعات للمحل') ?>
                </h1>
                <?= GridView::widget([
                    'dataProvider' => $dataProviderMarketExpenseGroup,
                    'columns'      => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'المبلغ',
                            'value' => function ($model) {
                                return $model['result'];
                            },
                        ],
                        [
                            'label' => 'السبب',
                            'value' => function ($model) {
                                return $model['reason'];
                            },
                        ],
                    ],
                ]) ?>
            </div>
            <div class="col-sm-6">
                <h1>
                    <?= $aus ?>
                    <?= Yii::t('app', ': شراء بضاعة للمحل') ?>
                </h1>
                <?= GridView::widget([
                    'dataProvider' => $dataProviderPurchasesGroup,
                    'columns'      => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'المبلغ',
                            'value' => function ($model) {
                                return $model['result'];
                            },
                        ],
                        [
                            'label' => 'السبب',
                            'value' => function ($model) {
                                return $model['reason'];
                            },
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
