<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchModel\ArticlePriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Article Prices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-price-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Article Price'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
