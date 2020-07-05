<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EstablishMarket */

$this->title                   = Yii::t('app', 'Update Establish Market: {name}', [
    'name' => $model->reason,
]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Establish Markets'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->reason,
    'url'   => [
        'view',
        'id' => $model->id,
    ],
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="establish-market-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
