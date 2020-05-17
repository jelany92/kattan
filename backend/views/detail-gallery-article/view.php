<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DetailGalleryArticle */

$this->title                   = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Detail Gallery Articles'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="detail-gallery-article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), [
            'update',
            'id' => $model->id,
        ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), [
            'delete',
            'id' => $model->id,
        ], [
                        'class' => 'btn btn-danger',
                        'data'  => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method'  => 'post',
                        ],
                    ]) ?>
    </p>

    <?= DetailView::widget([
                               'model'      => $model,
                               'attributes' => [
                                   'bookGalleries.author_name',
                                   'bookGalleries.book_pdf',
                                   'article_name_ar',
                                   'article_name_en',
                                   'link_to_preview:url',
                                   'description:raw',
                                   'selected_date',
                               ],
                           ]) ?>

</div>
