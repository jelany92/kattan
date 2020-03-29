<?php

use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModels array */
/* @var $dataProviders array */
/* @var $tabItems array */
$this->title                   = Yii::t('app', 'Globale Suche');
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
                'article_name_ar',
                'article_name_en',
                'article_photo',
                /*
                [
                    'label'  => 'fdfdsf',
                    'value'  => function ($model) {
                        var_dump($model->articlePrices['article_prise_per_piece']);die();
                        return $model->articlePrices->article_prise_per_piece;
                    },
                    'format' => 'raw',
                ],*/
            ],
        ]);
    }
    else
    {
        echo Html::tag('h3', Yii::t('app', 'Keine Ergebnisse gefunden'));
    }
    ?>

</div>

