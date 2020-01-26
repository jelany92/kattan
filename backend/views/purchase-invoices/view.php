<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseInvoices */
/* @var $dataProviderArticlePrice \yii\data\ActiveDataProvider */

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

    <h1>
        <?= Yii::t('app', 'Price this Invoice') ?>
        <?= Html::a(Yii::t('app', Yii::t('app', 'Invoice Export')), [
            'purchase-invoices/export',
            'purchaseInvoicesId' => $model->id,
        ], ['class' => 'btn btn-success']) ?>
    </h1>


    <?= GridView::widget([
        'dataProvider' => $dataProviderArticlePrice,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'article_info_id',
                'value'     => function ($model) {
                    return $model->articleInfo->article_name_ar;
                },
            ],
            'articleInfo.article_quantity',
            'article_prise_per_piece',
            'article_count',
            'article_total_prise',

            [
                'class'      => 'yii\grid\ActionColumn',
                'template'   => '{view} {update} {delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view')
                    {
                        $url = Yii::$app->urlManager->createUrl([
                            '/article-price/view',
                            'id' => $model->id,
                        ]);
                        return $url;
                    }
                    if ($action === 'update')
                    {
                        $url = Yii::$app->urlManager->createUrl([
                            '/article-price/update',
                            'id' => $model->id,
                        ]);
                        return $url;
                    }
                    if ($action === 'delete')
                    {
                        $url = Yii::$app->urlManager->createUrl([
                            '/article-price/delete',
                            'id' => $model->id,
                        ]);
                        return $url;
                    }
                },
            ],
        ],
    ]); ?>

</div>
