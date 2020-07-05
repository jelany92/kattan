<?php

use yii\bootstrap4\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Article In Storeds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-in-stored-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Article In Stored'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns' => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'count',
                                 [
                                     'class'     => 'kartik\grid\EditableColumn',
                                     'attribute' => 'count',
                                 ],
                                 [
                                     'label'  => Yii::t('app', 'Price'),
                                     'value'  => function ($model) {
                                         return $model->articleInfo->getMinPrice();
                                     },
                                     'format' => 'raw',
                                 ],
                                 'selected_date',

                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>

    <?php Pjax::end(); ?>

</div>