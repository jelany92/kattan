<?php

use yii\bootstrap4\Html;
use common\components\GridView;
use common\models\Category;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchModel\ArticleInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Article Infos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-info-index">

    <?php $form = ActiveForm::begin([
                                        'type'   => ActiveForm::TYPE_HORIZONTAL,
                                        'action' => ['index'],
                                        'method' => 'get',
                                    ]); ?>

    <?= $form->field($searchModel, 'article_name_ar') ?>

    <?php ActiveForm::end(); ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Article Info'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 [
                                     'attribute' => 'category_id',
                                     'filter'    => Html::activeDropDownList($searchModel, 'category_id', Category::getCategoryList(), [
                                         'class'  => 'form-control',
                                         'prompt' => Yii::t('app', 'Alle Kategory'),
                                     ]),
                                     'value'     => function ($model) {
                                         return Category::getCategoryList()[$model->category_id];
                                     },
                                 ],
                                 'article_name_ar',
                                 [
                                     'attribute' => 'article_photo',
                                     'value'     => function ($model) {
                                         $filesPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryArticle'] . DIRECTORY_SEPARATOR . $model->article_photo;
                                         $url       = Html::a(Yii::t('app', 'Bild'), $filesPath, ['target' => '_blank']);
                                         return $url;
                                     },
                                     'format'    => 'raw',
                                 ],
                                 'article_quantity',
                                 'article_unit',
                                 'article_buy_price',

                                 ['class' => 'common\components\ActionColumn'],
                             ],
                         ]); ?>


</div>
