<?php

use yii\bootstrap4\Html;
use common\components\GridView;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchModel\ArticleInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Article Infos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Article Info'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'category_id',
                'value' => function($model)
                {
                    return Category::getCategoryList()[$model->category_id];
                },
            ],
            'article_name',
            'article_photo',
            'article_unit',
            'selected_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
