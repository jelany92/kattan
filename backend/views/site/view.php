<?php

use yii\helpers\Html;
use backend\models\IncomingRevenue;
use backend\models\Purchases;
use backend\models\Capital;

/* @var $this yii\web\View */
/* @var $showCreate boolean */

$monthName = array( '','Januar','Februar','März', 'April','Mai','Juni', 'Juli','August','September', 'Oktober','November','Dezember');

$this->title = $date;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Arbeitszeits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$year = date("Y");

?>
<p>
    <?php if ($showCreate): ?>

        <?= Html::a(Yii::t('app', 'Verkaufen'), ['incoming-revenue/create'], ['class' => 'btn btn-success',
            'data' => [
                'method' => 'post',
                'params' => ['date' => $date], // <- extra level
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Einkaufen'), ['purchases/create'], ['class' => 'btn btn-success',
            'data' => [
                'method' => 'post',
                'params' => ['date' => $date], // <- extra level
            ],
        ]) . '<br />' ?>
    <?php endif; ?>

<?php
    $amountCash = IncomingRevenue::sumResultIncomingRevenue()['result'] + Capital::sumResultPurchases()['result'];
    $resultCash = $amountCash - Purchases::sumResultPurchases()['result'];
    echo '<h1>Total Einkommen : ' . $amountCash . '</h1>';
    echo '<h1>Total Ausgegben : ' . Purchases::sumResultPurchases()['result'] . '</h1>';
    echo '<h1>Result: ' . $resultCash . '</h1>';
    $totalIncomeOfTheShop = IncomingRevenue::sumResultIncomingRevenue()['result'];
    echo '<h1>Gesamteinkommen des Markt  : ' . $totalIncomeOfTheShop . '</h1>';

    echo '<h1>Statistiken Für ganze Monat</h1>';
    for ($m = 1; $m <= 12; $m++) {
        $monthName = date('F', mktime(0, 0, 0, $m, 1)) . '<br>';
        echo Html::a(Yii::t('app', $monthName), ['site/month-view' . '?year=' . $year . '&month=' . $m], ['', 'class' => 'btn btn-primary']);
    }
    echo '<h1>Statistiken Für Quartal</h1>';
    for ($i = 1; $i <= 4; $i++) {
        echo Html::a(Yii::t('app', $i), ['arbeitszeit/quartal-ansicht' . '?year=' . $year . '&quartal=' . $i], ['', 'class' => 'btn btn-primary']);

    }
    echo '<h1>Statistiken Für Jahr</h1>';

    for ($i = 2019; $i <= 2030; $i++)
    {
        echo Html::a(Yii::t('app', $i), ['site/year-view' . '?year=' . $i ], ['', 'class' => 'btn btn-primary']);
    }
    ?>
</p>

