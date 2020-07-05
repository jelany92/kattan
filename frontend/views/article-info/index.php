<?php

use yii\bootstrap4\Html;
use common\components\GridView;
use common\models\MainCategory;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchModel\ArticleInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Article Infos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'category_id',
                'filter'    => Html::activeDropDownList($searchModel, 'category_id', MainCategory::getMainCategoryList(), [
                    'class'  => 'form-control',
                    'prompt' => Yii::t('app', 'Alle Kategory'),
                ]),
                'value'     => function ($model) {
                    return MainCategory::getMainCategoryList(Yii::$app->user->id)[$model->category_id];
                },
            ],
            'article_name_ar',
            'article_photo',
            'article_quantity',
            'article_unit',
            'article_buy_price',

            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>


</div>
