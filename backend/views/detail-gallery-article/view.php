<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use kartik\social\FacebookPlugin;

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
$filesPath    = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPhoto'] . DIRECTORY_SEPARATOR . $model->bookGalleries->book_photo;
$filesPdfPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPdf'] . DIRECTORY_SEPARATOR . $model->bookGalleries->book_pdf;
?>
<div class="detail-gallery-article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->isGuest) : ?>

        <h1><?= Html::encode('اذا كنت تريد مشاهدة جميع الكتب يرجي تسجيل الدخول') . ' ' . Html::a(Yii::t('app', 'Sign in'), [
                'site/login',
            ], ['class' => 'btn btn-primary']) ?> </h1>

    <?php endif; ?>

    <p>
        <?php if (Yii::$app->user->can('admin') && Yii::$app->user->id == $model->company_id) : ?>
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

    <h3><?= Yii::t('app', 'ان اعجبك المحتوى لاتنسى Like و مشاركته لتعم الفائدة') ?></h3>
    <?= FacebookPlugin::widget([
                                   'type'     => FacebookPlugin::LIKE,
                                   'settings' => [
                                       'size'          => 'large',
                                       'layout'        => 'button_count',
                                       'mobile_iframe' => 'false',
                                   ],
                               ]); ?>
    <br>
    <br>
    <?= FacebookPlugin::widget([
                                   'type'     => FacebookPlugin::SHARE,
                                   'settings' => [
                                       'size'          => 'large',
                                       'layout'        => 'button_count',
                                       'mobile_iframe' => 'false',
                                   ],
                               ]); ?>
    <?= '<h1>' . Yii::t('app', 'Comment') . '</h1>' ?>

    <?= FacebookPlugin::widget([
                                   'type'     => FacebookPlugin::COMMENT,
                                   'settings' => [
                                       'data-width'    => 1000,
                                       'data-numposts' => 5,
                                   ],
                               ]); ?>

    <br><br><br>
    <div class="col-sm-3">
        <div class="view-info">
            <?= Html::img($filesPath, ['style' => 'width:100%height: 300px;margin-top: 50px']) ?>
        </div>
    </div>
    <div class="text col-sm-9">

        <?= DetailView::widget([
                                   'model'      => $model,
                                   'attributes' => [
                                       'article_name_ar',
                                       'article_name_en',
                                       'bookGalleries.bookAuthorName.name',
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
                                       'description:raw',
                                       'selected_date',
                                   ],
                               ]) ?>
    </div>
</div>
<div style="margin-top: 350px;">
    <h1><?= Yii::t('app', 'قراءة الكتاب') ?></h1>
    <p>
    <?= Html::a(Yii::t('app', 'Read'), $model->link_to_preview, [
        'class'  => 'btn btn-primary',
        'target' => '_blank',
    ]) ?>
    </p>
</div>