<?php

use yii\bootstrap4\Html;

use common\components\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseInvoices */
/* @var $dataProviderArticlePrice \yii\data\ActiveDataProvider */

$this->title                          = $model->seller_name;
$dataProviderArticlePrice->pagination = false;
?>
<div class="purchase-invoices-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProviderArticlePrice,
        'columns'      => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'attribute' => 'article_info_id',
                'label'     => Yii::t('app', 'اسم القطعة'),
                'value'     => function ($model) {
                    return $model->articleInfo->article_name_ar;
                },
            ],
            [
                'attribute' => 'articleInfo.article_quantity',
                'label'     => Yii::t('app', 'الكميه'),
                'value'     => function ($model) {
                    return $model->articleInfo->article_quantity . ' ' . $model->articleInfo->article_unit;
                },
            ],
            [
                'attribute' => 'article_prise_per_piece',
                'label'     => Yii::t('app', 'سعر القطعة'),
                'value'     => function ($model) {
                    return $model->article_prise_per_piece;
                },
            ],
            [
                'attribute' => 'article_count',
                'label'     => Yii::t('app', 'العدد'),
                'value'     => function ($model) {
                    return $model->article_count;
                },
            ],
            [
                'attribute' => 'article_total_prise',
                'label'     => Yii::t('app', 'السعر الكلي'),
                'value'     => function ($model) {
                    return $model->article_total_prise;
                },
            ],
        ],
    ]); ?>

</div>