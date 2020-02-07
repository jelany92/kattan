<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseInvoices */
/* @var $fileUrls array */
/* @var $invoiceFileList array */


$this->title                   = Yii::t('app', 'Update Purchase Invoices: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Purchase Invoices'),
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
<div class="purchase-invoices-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'           => $model,
        'fileUrls'        => $fileUrls,
        'invoiceFileList' => $invoiceFileList,


    ]) ?>

</div>
