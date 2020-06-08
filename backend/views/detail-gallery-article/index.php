<?php

use common\components\GridView;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\Tabs;

/* @var $this yii\web\View */
/* @var $mainCategoryNames array */
/* @var $searchModel common\models\searchModel\DetailGalleryArticlelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Detail Gallery Articles');
$this->params['breadcrumbs'][] = $this->title;
$items                         = [];
foreach ($mainCategoryNames as $mainCategoryName)
{
    $items[] = [
        'label'       => Icon::show('list-alt') . ' ' . $mainCategoryName,
        'linkOptions' => ['class' => 'tab-link'],
        'active'      => Yii::$app->controller->id == 'detail-gallery-article' && Yii::$app->controller->action->id == 'index' && Yii::$app->controller->actionParams['mainCategoryName'] == $mainCategoryName,
        'url'         => Yii::$app->urlManager->createUrl([
                                                              'detail-gallery-article/index',
                                                              'mainCategoryName' => $mainCategoryName,
                                                          ]),
        'encode'      => false,
    ];
}
?>
<div class="detail-gallery-article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('admin')) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Detail Gallery Article'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php if (0 < count($items)) : ?>
            <?= Tabs::widget([
                                 'options' => ['id' => 'main_category_nav'],
                                 'items'   => $items,
                             ]); ?>
        <br>
        <?php endif; ?>
    <?php endif; ?>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'article_name_ar',
                                 [
                                     'attribute' => 'author_name',
                                     'value'     => function ($model) {
                                         return $model->bookGalleries->author_name;
                                     },
                                 ],
                                 'selected_date',
                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>


</div>
