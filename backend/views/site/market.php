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

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <p>
        <?= Html::a(Yii::t('app', 'Demo Data'), ['demo-data'], ['class' => 'btn btn-success']) ?>
    </p>
    <br>
    <br>
    <h1><?= Yii::t('app', 'Total income for the month') . ' ' . $monthName[date('n')] . ': ' . QueryHelper::getMonthData(date('Y'), date('m'), 'incoming_revenue', 'daily_incoming_revenue') ?></h1>
    <br>

    <?= yii2fullcalendar\yii2fullcalendar::widget([
        'options'       => [
            'lang' => 'de',
            //... more options to be defined here!
        ],
        'clientOptions' => [
            //'hiddenDays'         => [0],
            // alle Tage auser Samstag un Sontag
            //'weekends' => false,                // oder so kann man auch ohne samstag und sonntag
            'weekNumbers'        => true,
            // in welche klendarwoceh steht
            //'weekNumbersWithinDays'=> true,   // merge mit erste tag in ansicht
            //'eventTextColor'=> 'black',       // fur textein farbe
            'eventStartEditable' => true,

            'dayClick' => new \yii\web\JsExpression('           // wenn ein auswälleen
                function(date, jsEvent, view) {
                window.location.href = "' . \yii\helpers\Url::toRoute([
                    '/site/view/',
                    'date' => '',
                ]) . '" + date.format("YYYY-MM-DD");
                  }
                '),
        ],
        'events'        => \yii\helpers\Url::to(['/site/get-events']),
    ]); ?>

</div>
