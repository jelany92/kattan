<?php

use common\components\QueryHelper;
use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $dataProviderResult ArrayDataProvider */

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

<?= $this->render('/site/supermarket/_sub_navigation', [
    'year'  => $year,
    'month' => $month,
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
                                     'dataProvider' => $dataProviderResult,
                                     'columns'      => [
                                         ['class' => 'yii\grid\SerialColumn'],
                                         [
                                             'label' => Yii::t('app', 'Selected Date'),
                                             'value' => function ($model) {
                                                 //var_dump($model);die();
                                                 return $model;
                                             },
                                         ],
                                     ],
                                 ]) ?>
        </div>
    </div>
</div>


