<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseInvoices */

$this->title                   = $model->seller_name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Purchase Invoices'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="purchase-invoices-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), [
            'update',
            'id' => $model->id,
        ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), [
            'delete',
            'id' => $model->id,
        ], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'invoice_name',
            'invoice_description',
            'seller_name',
            'amount',
            'selected_date',
            [
                'attribute' => 'invoicePhotos.photo_path',
                'value'     => function ($model) {
                    $url = [];
                    foreach ($model->invoicePhotos as $file)
                    {
                        $filesPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryMail'] . DIRECTORY_SEPARATOR . $file->photo_path;
                        $url[]     = Html::a(Yii::t('app', 'Rechnung File'), $filesPath, ['target' => '_blank']);
                    }
                    return implode("<br>", $url);
                },
                'format'    => 'raw',

            ],
        ],
    ]) ?>

</div>
