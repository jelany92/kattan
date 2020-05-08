<?php

use common\components\QueryHelper;
use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $modelIncomingRevenue ArrayDataProvider */

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

$ein = QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue');
?>

<?= $this->render('/site/_sub_navigation', [
    'year'  => $year,
    'month' => $month,login
]) ?>
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <h1>
                <?= $ein ?>
                <?= Yii::t('app', 'تفاصيل الدخل') ?>
                <?= Html::a(Yii::t('app', 'All Einkommen'), ['incoming-revenue/index'], ['class' => 'btn btn-success']) ?>
            </h1>
            <?= GridView::widget([
                                     'dataProvider' => $modelIncomingRevenue,
                                     'columns' => [
                                         ['class' => 'yii\grid\SerialColumn'],
                                         'date',
                                         'total',
                                     ],
                                 ]) ?>
        </div>
    </div>
</div>


