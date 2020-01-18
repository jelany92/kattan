<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use common\models\Article;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Article'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'article_name',
            [
                'attribute' => 'category_id',
                'value' => function($model)
                {
                    return Category::getCategoryList()[$model->category_id];
                },
            ],
            'article_count',
            [
                'attribute' => 'article_unit',
                'value' => function($model)
                {
                    return Article::UNIT_LIST[$model->article_unit];
                },
            ],            'article_total_prise',
            'article_prise_per_piece',
            [
                'attribute' => 'status',
                'value' => function( $model )
                {
                    return Article::STATUS[$model->status];
                },
            ],            'seller_name',
            'selected_date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
