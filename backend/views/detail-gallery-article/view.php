<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DetailGalleryArticle */

$this->title = $model->article_name_ar;
if (Yii::$app->user->can('admin') && Yii::$app->user->id == $model->company_id)
{
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('app', 'Detail Gallery Articles'),
        'url'   => ['index'],
    ];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$filesPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPhoto'] . DIRECTORY_SEPARATOR . $model->bookGalleries->book_photo;

?>
<div class="detail-gallery-article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->isGuest) : ?>

        <h1><?= Html::encode('اذا كنت تريد مشاهدة جميع الكتب يرجي تسجيل الدخول') . ' ' . Html::a(Yii::t('app', 'Sign in'), [
                'site/login',
            ], ['class' => 'btn btn-primary']) ?> </h1>

    <?php endif; ?>

    <?php if (Yii::$app->user->can('admin') && Yii::$app->user->id == $model->company_id) : ?>
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
        <?php endif; ?>
    </p>
    <br><br><br>
    <div class="col-sm-3">
        <div class="view-info">
            <?= Html::img($filesPath, ['style' => 'width:250px;height: 300px']) ?>
        </div>
    </div>
    <div class="text col-sm-9">

        <?= DetailView::widget([
                                   'model'      => $model,
                                   'attributes' => [
                                       'article_name_ar',
                                       'article_name_en',
                                       'bookGalleries.author_name',
                                       [
                                           'attribute' => 'bookGalleries.book_pdf',
                                           'value'     => function ($model) {
                                               if (isset($model->bookGalleries->book_pdf))
                                               {
                                                   return Html::a(Yii::t('app', 'Download'), [
                                                       'detail-gallery-article/download',
                                                       'id' => $model->id,
                                                   ]);
                                               }
                                           },
                                           'format'    => 'raw',
                                       ],
                                       [
                                           'label'  => Yii::t('app', 'Read'),
                                           'value'  => function ($model) {
                                               if (isset($model->bookGalleries->book_pdf))
                                               {
                                                   $filesPdfPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPdf'] . DIRECTORY_SEPARATOR . $model->bookGalleries->book_pdf;
                                                   return Html::a(Yii::t('app', 'Read'), $filesPdfPath, [
                                                       'style'  => 'margin-top: 10px;',
                                                       'target' => '_blank',
                                                   ]);
                                               }
                                           },
                                           'format' => 'raw',
                                       ],
                                       'link_to_preview:url',
                                       'description:raw',
                                       'selected_date',
                                   ],
                               ]) ?>

    </div>
</div>
