<?php

use yii\bootstrap4\Html;
use common\components\GridView;
use common\widgets\Table;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\CapitalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tableInformationEntry array */
/* @var $tableInformationWithdrawal array */
/* @var $tableInformationStock array */

$this->title                   = Yii::t('app', 'Capitals');
$this->params['breadcrumbs'][] = $this->title;
$tableContent                  = [
    'tableArray' => [
        [

            [
                'type' => 'td',
                'html' => '<strong>' . Yii::t('app', 'Name') . '</strong>',
            ],
            [
                'type' => 'td',
                'html' => '<strong>' . Yii::t('app', 'Status') . '</strong>',
            ],
            [
                'type' => 'td',
                'html' => '<strong>' . Yii::t('app', 'Amount') . '</strong>',
            ],
        ],
    ],
];
foreach ($tableInformationEntry as $key => $entry)
{
    $tableContent['tableArray'][] = [
        [
            'type' => 'td',
            'html' => $entry['name'],
        ],
        [
            'type' => 'td',
            'html' => Yii::t('app', 'Entry'),
        ],
        [
            'type' => 'td',
            'html' => $entry['amount'],
        ],
    ];
}
foreach ($tableInformationWithdrawal as $key => $withdrawal)
{
    $tableContent['tableArray'][] = [
        [
            'type' => 'td',
            'html' => Yii::t('app', 'Withdrawal'),
        ],
        [
            'type' => 'td',
            'html' => $withdrawal['amount'],
        ],
        [
            'type' => 'td',
            'html' => $withdrawal['name'],
        ],
    ];
}
foreach ($tableInformationStock as $key => $stock)
{
    $tableContent['tableArray'][] = [
        [
            'type'  => 'td',
            'html'  => Yii::t('app', 'Stock'),
            'style' => 'background-color:#22b94f',
        ],
        [
            'type'  => 'td',
            'html'  => $stock['stock'],
            'style' => 'background-color:#22b94f',
        ],
        [
            'type'  => 'td',
            'html'  => $stock['name'],
            'style' => 'background-color:#22b94f',
        ],
    ];
}


?>
<div class="capital-index">
    <?= Table::widget($tableContent); ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Capital'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],

                                 'name',
                                 [
                                     'attribute' => 'company_id',
                                     'value'     => function ($model) {
                                         return $model->user->company_name;
                                     },
                                 ],
                                 'amount',
                                 'selected_date',
                                 'status',

                                 [
                                     'class'    => 'common\components\ActionColumn',
                                     'template' => '{update} {delete}',
                                 ],
                             ],
                         ]); ?>


</div>
