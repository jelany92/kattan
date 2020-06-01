<?php

use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchModel\DetailGalleryArticlelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Detail Gallery Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail-gallery-article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('admin')) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Detail Gallery Article'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
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
                                 //'article_name_en',
                                 //'link_to_preview:url',
                                 'selected_date',
                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>


</div>
