<?php

use common\components\GridView;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\ArticleInventorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Article In Inventory');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-in-stored-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Article In Stored'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Create new Inventory'), ['inventory'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'inventory_name',
                                 [
                                     'class'      => 'common\components\ActionColumn',
                                     'template'   => '{view} {delete}',
                                     'urlCreator' => function ($action, $model) {
                                         if ($action === 'view')
                                         {
                                             $url = Yii::$app->urlManager->createUrl([
                                                                                         'article-in-stored/index',
                                                                                         'id' => $model['id'],
                                                                                     ]);
                                             return $url;
                                         }
                                         if ($action === 'delete')
                                         {
                                             $url = Yii::$app->urlManager->createUrl([
                                                                                         'article-in-stored/delete-inventory',
                                                                                         'id' => $model['id'],
                                                                                     ]);
                                             return $url;
                                         }
                                     },
                                 ],
                             ],
                         ]); ?>


</div>
