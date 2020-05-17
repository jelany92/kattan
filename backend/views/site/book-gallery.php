<?php

use common\components\QueryHelper;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
$monthName = [
    '',
    'Januar',
    'Februar',
    Yii::t('app', 'March'),
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
?>
<div class="site-index">
    <?php if (Yii::$app->user->id != 3) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Demo Data'), ['demo-data'], ['class' => 'btn btn-success']) ?>
        </p>
        <br>
        <br>
    <?php endif; ?>
    <h1><?= Yii::t('app', 'Total income for the month') . ' ' . $monthName[date('n')] . ': ' . QueryHelper::getMonthData(date('Y'), date('m'), 'incoming_revenue', 'daily_incoming_revenue') ?></h1>
    <br>

</div>
