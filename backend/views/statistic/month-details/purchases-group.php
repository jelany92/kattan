<?php

use common\components\QueryHelper;
use yii\bootstrap4\Html;
use common\components\GridView;

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

<?= $this->render('/site/supermarket/_sub_navigation',[
    'year'  => $year,
    'month' => $month,
]) ?>
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <h1>
                <?= $aus ?>
                <?= Yii::t('app', 'تفاصيل المدفوعات مجمعين (شراء بضاعة)') ?>
                <?= Html::a(Yii::t('app', 'All Ausgeben'), ['purchases/index'], ['class' => 'btn btn-success']) ?>
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
                                         [
                                             'label' => Yii::t('app', 'Selected Date'),
                                             'value' => function ($model) {
                                                 return $model['selected_date'];
                                             },
                                         ],
                                     ],
                                 ]) ?>
        </div>
    </div>
</div>


