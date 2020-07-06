<?php

use yii\bootstrap4\Html;
use common\components\GridView;
use kartik\icons\Icon;
use yii\helpers\Url;

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
        'options'      => [
            'id'    => 'permission_grid',
            'style' => 'overflow: auto; word-wrap: break-word;',
        ],
        'rowOptions'   => function ($model) {
            $articlePriceId = [];
            foreach ($model->articlePrices as $key => $articlePrice)
            {
                $articlePriceId[] = $articlePrice->purchase_invoices_id;
            }
            if (0 < count($articlePriceId))
            {
                return ['style' => 'background-color:#20C996'];
            }

        },
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            'invoice_name',
            'invoice_description',
            'seller_name',
            'amount',
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
            'selected_date',

            [
                'class'      => 'common\components\ActionColumn',
                'template'   => '{view} {update} {delete} {create-price-lis}',
                'buttons'    => [
                    'create-price-lis' => function ($url) {
                        return Html::a(Icon::show('money-bill-alt'), $url, [
                            'title' => 'test',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $modelPurchaseInvoices, $key) {
                    if ($action == 'create-price-lis')
                    {
                        return Url::to([
                            'purchase-invoices/create',
                            'purchase-invoices-id' => $modelPurchaseInvoices->id,
                        ]);
                    }

                    return Url::to([
                        $action,
                        'id' => $key,
                    ]);
                },
            ],
        ],
    ]); ?>


</div>
