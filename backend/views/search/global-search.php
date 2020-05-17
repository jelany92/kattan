<?php

use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModels array */
/* @var $dataProviders array */
/* @var $tabItems array */
$this->title                   = Yii::t('app', 'Global search');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-global-search">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (0 < $dataProvider->totalCount)
    {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'id'           => 'grid_admin_search',
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                'article_name_ar',
                'article_name_en',
                'article_unit',
                'article_quantity',
                'article_buy_price',
                [
                    'label'  => Yii::t('app', 'Article Prise Per Piece'),
                    'value'  => function ($model) {
                        $price = [];
                        foreach ($model->articlePrices as $articlePrisePerPiece)
                        {
                            $price[] = $articlePrisePerPiece->article_prise_per_piece;
                        }
                        if (0 < count($price))
                        {
                            return implode(' | ', array_unique($price));
                        }
                        return $price;

                    },
                    'format' => 'raw',
                ],
                [
                    'label'  => Yii::t('app', 'Article Total Prise'),
                    'value'  => function ($model) {
                        $price = [];
                        foreach ($model->articlePrices as $articlePrisePerPiece)
                        {
                            $price[] = $articlePrisePerPiece->article_total_prise;
                        }
                        if (0 < count($price))
                        {
                            return implode(' | ', array_unique($price));
                        }
                        return $price;

                    },
                    'format' => 'raw',
                ],
            ],
        ]);
    }
    else
    {
        echo Html::tag('h3', Yii::t('app', 'No Results Found'));
    }
    ?>

</div>

