<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use common\components\GridView;
use common\models\MainCategory;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleInfo */
/* @var $dataProviderArticlePrice common\models\ArticlePrice */

$this->title                   = $model->article_name_ar;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Article Infos'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
$filesPath                     = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryArticle'] . DIRECTORY_SEPARATOR . $model->article_photo;
\yii\web\YiiAsset::register($this);
?>
<div class="article-info-view">

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
    <br><br>
    <div class="col-sm-9">
        <?= DetailView::widget([
                                   'model'      => $model,
                                   //'options' => ['class' => ''],
                                   'attributes' => [
                                       [
                                           'attribute' => 'category_id',
                                           'value'     => function ($model) {
                                               return MainCategory::getMainCategoryList()[$model->category_id];
                                           },
                                       ],
                                       'article_name_ar',
                                       'article_quantity',
                                       'article_unit',
                                       'article_buy_price',
                                   ],
                               ]) ?>
    </div>
    <div class="single-products col-sm-3">
        <div class="view-info text-right">
            <?= Html::img($filesPath, ['style' => 'width:275px;height: 300px']) ?>
        </div>
    </div>

    <br>
    <div class="col-sm-12">
        <h1><?= Yii::t('app', 'Price') ?></h1>

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
                                     'article_prise_per_piece',
                                     [
                                         'label'  => Yii::t('app', 'Seller Name'),
                                         'value'  => function ($model) {
                                             return Html::a($model->purchaseInvoices->seller_name, [
                                                 'purchase-invoices/view',
                                                 'id' => $model->purchaseInvoices->id,
                                             ], ['target' => '_blank']);
                                         },
                                         'format' => 'raw',
                                     ],
                                     'selected_date',

                                     [
                                         'class'      => 'common\components\ActionColumn',
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

</div>
