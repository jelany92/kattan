<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MarketExpense */
/* @var $reasonList array */

$this->title                   = Yii::t('app', 'Update Market Expense: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Market Expenses'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->id,
    'url'   => [
        'view',
        'id' => $model->id,
    ],
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="market-expense-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'      => $model,
        'reasonList' => $reasonList,

    ]) ?>

</div>
