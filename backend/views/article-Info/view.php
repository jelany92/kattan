<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Category;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleInfo */
/* @var $dataProviderArticlePrice common\models\ArticlePrice */

$this->title = $model->article_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Article Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'category_id',
                'value' => function($model)
                {
                    return Category::getCategoryList()[$model->category_id];
                },
            ],            'article_name',
            'article_photo',
            'article_unit',
            'status',
            'selected_date',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProviderArticlePrice,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'article_info_id',
                'value' => function( $model )
                {
                    return $model->articleInfo->article_name;
                },
            ],
            'article_total_prise',
            'article_prise_per_piece',
            'seller_name',
            'selected_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
