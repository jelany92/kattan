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
<div class="container">

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
            ],
        ]);
    }
    else
    {
        echo Html::tag('h3', Yii::t('app', 'No Results Found'));
    }
    ?>

</div>

