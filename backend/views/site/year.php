
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\IncomingRevenue;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $statistikMonatProvider ArrayDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>


<div class="Monat Ansicht-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <h1><?= Html::a('zurück', ['site/view', 'date' => Yii::$app->session->get('returnDate')], ['', 'class' => 'btn btn-success']) . '</br>'; ?></h1>
    <h1><?= 'Total Einkommen : ' . IncomingRevenue::getYearData($year, 'daily_incoming_revenue') ?></h1>

    <form method="post">

    </form>
</div>
