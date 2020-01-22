<?php

use yii\helpers\Html;
use backend\models\IncomingRevenue;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $statistikMonatProvider ArrayDataProvider */
/* @var $modelIncomingRevenue ArrayDataProvider */
/* @var $modelPurchases ArrayDataProvider */

$monthName = array('', 'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
$this->title = Yii::t('app', $monthName[$month] . ' Monat');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="Monat Ansicht-index">
    <form method="post">
        <?php
        for ($m = 1; $m <= 12; $m++) {
            $monthName = date('F', mktime(0, 0, 0, $m, 1)) . '<br>';
            echo Html::a(Yii::t('app', $monthName), ['month-view' . '?year=' . $year . '&month=' . $m], ['', 'class' => 'btn btn-primary', 'style' => $month == $m ? 'background-color: #40a7ff;' : '']) . ' ';
        }
        ?>
    </form>
    <h1><?= Html::a('zurück', ['site/view', 'date' => Yii::$app->session->get('returnDate')], ['', 'class' => 'btn btn-success']) . '</br>'; ?></h1>
    <h1><?= Html::encode($this->title) ?></h1>
    <h1><?= 'Gesamteinkommen für den Monat ' . $monthName[$month] . ': ' . IncomingRevenue::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue') ?></h1>
    <h1><?= 'Gesamtausgeben für den Monat ' . $monthName[$month] . ': ' . IncomingRevenue::getMonthData($year, $month, 'purchases', 'purchases') ?></h1>

    <div class="col-sm-6">
        <h1>
            <?= Yii::t('app', 'Details Einkommen:') ?>
            <?= Html::a(Yii::t('app', 'All Einkommen'), ['incoming-revenue/index'], ['class' => 'btn btn-success']) ?>
        </h1>
        <?= \common\components\GridView::widget([
            'dataProvider' => $modelIncomingRevenue,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'date',
                'total_income',
            ],
        ]) ?>
    </div>
    <div class="col-sm-6">
        <h1>
            <?= Yii::t('app', 'Details Ausgeben:') ?>
            <?= Html::a(Yii::t('app', 'All Ausgeben'), ['purchases/index'], ['class' => 'btn btn-success']) ?>
        </h1>
        <?= \common\components\GridView::widget([
            'dataProvider' => $modelPurchases,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'date',
                'total_output',
            ],
        ]) ?>
    </div>
</div>
