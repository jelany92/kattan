<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchModel\ArticlePriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Article Prices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-price-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', Yii::t('app', 'Article Price Export')), [
            'article-price/export',
        ], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'article_info_id',
                'value'     => function ($model) {
                    return Html::a($model->articleInfo->article_name_ar, [
                        'article-info/view',
                        'id' => $model->articleInfo->id,
                    ]);
                },
                'format'    => 'raw',
            ],
            'article_total_prise',
            'article_prise_per_piece',
            [
                'label'  => Yii::t('app', 'Rechnung File'),
                'value'  => function ($model) {
                    $url = [];
                    foreach ($model->purchaseInvoices->invoicePhotos as $file)
                    {
                        $filesPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryMail'] . DIRECTORY_SEPARATOR . $file->photo_path;
                        $url[]     = Html::a($model->purchaseInvoices->seller_name, $filesPath, ['target' => '_blank']);
                    }
                    return implode("<br>", $url);
                },
                'format' => 'raw',

            ],
            'selected_date',

            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>

</div>
