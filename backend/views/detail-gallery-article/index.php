<?php

use common\components\GridView;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\Tabs;

/* @var $this yii\web\View */
/* @var $mainCategoryNames array */
/* @var $subcategoryNames array */
/* @var $searchModel common\models\searchModel\DetailGalleryArticlelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Detail Gallery Articles');
$this->params['breadcrumbs'][] = $this->title;
$mainCategoryItems             = [];
$subcategoryItems              = [];
foreach ($mainCategoryNames as $mainCategoryName)
{
    $mainCategoryItems[] = [
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
foreach ($subcategoryNames as $key => $subcategoryName)
{
    $subcategoryItems[] = [
        'label'       => Icon::show('list-alt') . ' ' . $subcategoryName,
        'linkOptions' => ['class' => 'tab-link'],
        'active'      => Yii::$app->controller->id == 'detail-gallery-article' && Yii::$app->controller->action->id == 'index' && Yii::$app->controller->actionParams['mainCategoryName'] == Yii::$app->request->get('mainCategoryName') &&
                         Yii::$app->controller->actionParams['subcategoryId'] == $key,
        'url'         => Yii::$app->urlManager->createUrl([
                                                              'detail-gallery-article/index',
                                                              'mainCategoryName' => Yii::$app->request->get('mainCategoryName'),
                                                              'subcategoryId'  => $key,
                                                          ]),
        'encode'      => false,
    ];
}
?>
<div class="detail-gallery-article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('detail-gallery-article.*')) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Detail Gallery Article'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php if (0 < count($mainCategoryItems)) : ?>
            <h1><?= Yii::t('app', 'Main Category') ?></h1>
            <?= Tabs::widget([
                                 'options' => ['id' => 'main_category_nav'],
                                 'items'   => $mainCategoryItems,
                             ]); ?>
            <?php if ((0 < count($subcategoryItems)) && Yii::$app->request->get('mainCategoryName') != null) : ?>
                <h1><?= Yii::t('app', 'Subcategory') ?></h1>
                <?= Tabs::widget([
                                     'options' => ['id' => 'main_category_nav'],
                                     'items'   => $subcategoryItems,
                                 ]); ?>
            <?php endif; ?>
        <?php endif; ?>
        <br>
    <?php endif; ?>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'options'      => [
                                 'id'    => 'permission_grid',
                                 'style' => 'overflow: auto; word-wrap: break-word;',
                             ],
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'article_name_ar',
                                 [
                                     'attribute' => 'authorName',
                                     'value'     => function ($model) {
                                         return $model->bookGalleries->bookAuthorName->name;
                                     },
                                 ],
                                 'selected_date',
                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>


</div>
