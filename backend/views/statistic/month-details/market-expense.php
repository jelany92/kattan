<?php

use common\components\QueryHelper;
use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
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

$ausMarket = QueryHelper::getMonthData($year, $month, 'market_expense', 'expense');
?>

<?= $this->render('/site/_sub_navigation',[
    'year'  => $year,
    'month' => $month,
]) ?>
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
                    'date',
                    'total',
                    'reason',
                ],
            ]) ?>
        </div>
    </div>
</div>


