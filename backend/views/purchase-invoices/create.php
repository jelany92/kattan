<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseInvoices */
/* @var $invoiceFileList array */
/* @var $fileUrls array */

$this->title                   = Yii::t('app', 'Create Purchase Invoices');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Purchase Invoices'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-invoices-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'           => $model,
        'fileUrls'        => $fileUrls,
        'invoiceFileList' => $invoiceFileList,
    ]) ?>

</div>
