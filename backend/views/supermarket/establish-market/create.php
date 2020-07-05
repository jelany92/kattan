<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EstablishMarket */

$this->title                   = Yii::t('app', 'Create Establish Market');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Establish Markets'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="establish-market-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
