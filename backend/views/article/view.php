<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use common\models\Article;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

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
            ],
            'article_name',
            'article_photo',
            'article_count',
            [
                'attribute' => 'article_unit',
                'value' => function($model)
                {
                    return Article::UNIT_LIST[$model->article_unit];
                },
            ],
            'article_total_prise',
            'article_prise_per_piece',
            [
                'attribute' => 'status',
                'value' => function( $model )
                {
                    return Article::STATUS[$model->status];
                },
            ],
            'seller_name',
            'selected_date',
        ],
    ]) ?>

</div>
