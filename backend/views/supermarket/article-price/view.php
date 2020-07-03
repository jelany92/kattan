<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ArticlePrice */

$this->title                   = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Article Prices'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$filesPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryArticle'] . DIRECTORY_SEPARATOR . $model->articleInfo->article_photo;
?>
<div class="article-price-view">

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
    <div class="single-products col-sm-9">
        <?= DetailView::widget([
                                   'model'      => $model,
                                   'attributes' => [
                                       'article_info_id',
                                       'article_total_prise',
                                       'article_count',
                                       'article_prise_per_piece',

                                       'selected_date',
                                   ],
                               ]) ?>
    </div>
    <div class="single-products col-sm-3">
        <div class="view-info text-right">
            <?= Html::img($filesPath, ['style' => 'width:100%;height: 300px']) ?>
        </div>
    </div>

</div>
