<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\PurchaseInvoicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Purchase Invoices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-invoices-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Purchase Invoices'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'invoice_name',
            'invoice_description',
            'seller_name',
            'amount',
            [

                'attribute' => 'invoicePhotos.photo_path',
                'value'     => function ($model) {
                    $files  = [];
                    foreach ($model->invoicePhotos as $file)
                    {
                        $files[] = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryMail']. DIRECTORY_SEPARATOR . $file->photo_path;
                    }
                    $implode = implode("\n", $files);
                    return  $implode;
                    return  HTML::img($implode, ['style' => 'width:25px;', 'height: 25px;']);
                },
                'format'    => 'raw',

            ],
            'selected_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
