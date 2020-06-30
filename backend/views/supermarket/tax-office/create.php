<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TaxOffice */
/* @var $reasonList array */

$this->title                   = Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Tax Office');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tax Office'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tax-office-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'      => $model,
        'reasonList' => $reasonList,

    ]) ?>

</div>
