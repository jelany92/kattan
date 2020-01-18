<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\Category;
use common\models\Article;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $dataProviderArticle yii\data\ActiveDataProvider*/

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

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
            'category_name',
        ],
    ]) ?>

    <div class="row">
        <div class="col-md-9">
            <h1><?= Yii::t('app','Article') ?></h1>
            <?= GridView::widget([
                'dataProvider' => $dataProviderArticle,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'article_name',
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
                    ],            'seller_name',
                    'selected_date',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
