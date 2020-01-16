<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\IncomingRevenue;
use backend\models\Purchases;

/* @var $this yii\web\View */
/* @var $showCreate boolean */


$this->title = $date;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Arbeitszeits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
    echo '<h1>Total Einkommen : ' . IncomingRevenue::sumResultIncomingRevenue()['result'] . '</h1>';
    echo '<h1>Total Ausgegben : ' . Purchases::sumResultPurchases()['result'] . '</h1>';
    $result = IncomingRevenue::sumResultIncomingRevenue()['result'] - Purchases::sumResultPurchases()['result'];
    echo '<h1>Result Einkommen : ' . $result . '</h1>';
    echo '<h1>Statistiken Für die Wochen in der Monat</h1>';
    $year = date("Y");
    for ($m = 1; $m <= 12; $m++) {
        $monthName = date('F', mktime(0, 0, 0, $m, 1)) . '<br>';
        echo Html::a(Yii::t('app', $monthName), ['arbeitszeit/wochen-ansicht?year=' . $year . '&month=' . $m], ['class' => 'btn btn-info pull-link']);
    }
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
<span class="clearfix"> </span>


<div class="arbeitszeit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $actionCol = [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Option',
        'headerOptions' => ['style' => 'color:#337ab7'],
        'template' => '{view} {update} {delete}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('app', 'view'),
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('app', 'update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => Yii::t('app', 'delete'), 'data' => [
                        'confirm' => "Are you sure you want to delete profile?",
                        'method' => 'post',
                    ],
                ]);
            }

        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            switch ($model['type']) {
                case 'A':
                    $c = 'arbeitszeit';
                    break;
                case 'P':
                    $c = 'pausenzeit';
                    break;
                case 'U':
                    $c = 'urlaub';
                    break;
            }
            if ($action === 'view') {
                $url = Yii::$app->urlManager->createUrl(["/$c/view", 'id' => $model['id']]);
                return $url;
            }

            if ($action === 'update') {
                $url = Yii::$app->urlManager->createUrl(["/$c/update", 'id' => $model['id']]);
                return $url;
            }
            if ($action === 'delete') {
                $url = Yii::$app->urlManager->createUrl(["/$c/delete", 'id' => $model['id']
                ]);
                return $url;

            }

        }
    ]

    ?>
</div>

