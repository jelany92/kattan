<?php

use common\models\ArticleInfo;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $dataProviderArticle yii\data\ActiveDataProvider */

$this->title                   = $model->category_name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Categories'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
$filesPath                     = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryCategory'] . DIRECTORY_SEPARATOR . $model->category_photo;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

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
    <br><br><br>
    <div class="col-sm-8">
        <?= DetailView::widget([
                                   'model'      => $model,
                                   'attributes' => [
                                       'category_name',
                                   ],
                               ]) ?>
    </div>
    <div class="category-photo col-sm-4">
        <div class="view-info text-right">
            <?= Html::img($filesPath, ['style' => 'width:350px;height: 300px']) ?>
        </div>
    </div>
    <br>
    <div class="row col-xl-12">
        <div class="col-md-12">
            <h1><?= Yii::t('app', 'Article') ?></h1>
            <?= GridView::widget([
                                     'dataProvider' => $dataProviderArticle,
                                     'columns'      => [
                                         ['class' => 'yii\grid\SerialColumn'],

                                         'article_name_ar',
                                         //'article_count',
                                         [
                                             'attribute' => 'article_unit',
                                             'value'     => function ($model) {
                                                 return ArticleInfo::UNIT_LIST[$model->article_unit];
                                             },
                                         ],
                                         [
                                             'class'      => 'common\components\ActionColumn',
                                             'template'   => '{view} {update} {delete}',
                                             'urlCreator' => function ($action, $model, $key, $index) {
                                                 if ($action === 'view')
                                                 {
                                                     $url = Yii::$app->urlManager->createUrl([
                                                                                                 '/article-info/view',
                                                                                                 'id' => $model->id,
                                                                                             ]);
                                                     return $url;
                                                 }
                                                 if ($action === 'update')
                                                 {
                                                     $url = Yii::$app->urlManager->createUrl([
                                                                                                 '/article-info/update',
                                                                                                 'id' => $model->id,
                                                                                             ]);
                                                     return $url;
                                                 }
                                                 if ($action === 'delete')
                                                 {
                                                     $url = Yii::$app->urlManager->createUrl([
                                                                                                 '/article-info/delete',
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
</div>
