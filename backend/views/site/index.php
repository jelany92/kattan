<?php

use common\components\QueryHelper;
/* @var $this yii\web\View */
$monthName = array( '','Januar','Februar','März', 'April','Mai','Juni', 'Juli','August','September', 'Oktober','November','Dezember');

$this->title = 'My Yii Application';
?>
<div class="site-index">
<br>
<br>
    <h1><?= 'Gesamteinkommen für den Monat '. $monthName[date('n')].': ' . QueryHelper::getMonthData(date('Y'), date('m'), 'incoming_revenue','daily_incoming_revenue') ?></h1>
    <br>

    <?= yii2fullcalendar\yii2fullcalendar::widget([
        'options' => [
            'lang' => 'de',
            //... more options to be defined here!
        ],
        'clientOptions' => [
            'hiddenDays' => array(0),         // alle Tage auser Samstag un Sontag
            //'weekends' => false,                // oder so kann man auch ohne samstag und sonntag
            'weekNumbers'=> true,               // in welche klendarwoceh steht
            //'weekNumbersWithinDays'=> true,   // merge mit erste tag in ansicht
            //'eventTextColor'=> 'black',       // fur textein farbe
            'eventStartEditable'=> true,

            'dayClick' => new \yii\web\JsExpression('           // wenn ein auswälleen
                function(date, jsEvent, view) {
                window.location.href = "' . \yii\helpers\Url::toRoute(['/site/view/', 'date' => '']) . '" + date.format("YYYY-MM-DD");
                  }
                '),
        ],
        'events' => \yii\helpers\Url::to(['/site/get-events'])
    ]);
    ?>
</div>
