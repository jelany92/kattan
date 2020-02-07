
<?php

use yii\bootstrap4\Html;
use backend\models\IncomingRevenue;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $statistikMonatProvider ArrayDataProvider */

$this->title = Yii::t('app', 'Jahr: ' . $year);
$this->params['breadcrumbs'][] = Yii::t('app', 'Jahr');
?>


<div class="Monat Ansicht-index">
    <h1><?= Html::a('zurück', ['site/view', 'date' => Yii::$app->session->get('returnDate')], ['', 'class' => 'btn btn-success']) . '</br>'; ?></h1>
    <h1><?= Html::encode($this->title) ?></h1>
    <h1><?= 'Total Einkommen : ' . IncomingRevenue::getYearData($year, 'incoming_revenue', 'daily_incoming_revenue') ?></h1>

    <form method="post">
        <?php
        for ($m = 1; $m <= 12; $m++) {
            $monthName = date('F', mktime(0, 0, 0, $m, 1)) . '<br>';
        }
        ?>
    </form>
    <?= \common\components\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            '0',  // key for month
        ],
    ]) ?>
</div>
