<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle \common\models\DetailGalleryArticle */
$this->registerAssetBundle('backend\assets\BookGallery');
?>
<div class="body">
    <?php if (Yii::$app->user->id != 3) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Demo Data'), ['demo-data'], ['class' => 'btn btn-success']) ?>
        </p>
        <br>
        <br>
    <?php endif; ?>
    <h1><?= Yii::t('app', 'اصنع مكتبتك الخاصة') ?></h1>
    <br>

    <div class="row">
        <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
            <div class="col-md-3">
                <?php
                $filesPhotoPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPhoto'] . DIRECTORY_SEPARATOR . $detailGalleryArticle->bookGalleries->book_photo;
                $filesPdfPath   = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPdf'] . DIRECTORY_SEPARATOR . $detailGalleryArticle->bookGalleries->book_pdf;
                $filesPdfRoot   = $detailGalleryArticle->bookGalleries->getAbsolutePath(Yii::$app->params['uploadDirectoryBookGalleryPdf'], $detailGalleryArticle->bookGalleries->book_pdf);
                ?>
                <?= Html::img($filesPhotoPath, ['style' => 'width:255px;height: 330px']) ?>
                <?= Html::a(Yii::t('app', 'Details'), [
                    'detail-gallery-article/view',
                    'id' => $detailGalleryArticle->id,
                ], [
                                'class' => 'btn btn-info',
                                'style' => 'margin-top: 10px;',
                            ]) ?>
                <?php if (file_exists($filesPdfRoot)) : ?>
                    <?= Html::a(Yii::t('app', 'Read'), $filesPdfPath, [
                        'class' => 'btn btn-secondary',
                        'style' => 'margin-top: 10px;',
                    ]) ?>
                <?php endif; ?>
                <?= Html::a(Yii::t('app', 'Download'), [
                    'detail-gallery-article/download',
                    'id' => $detailGalleryArticle->id,
                ], [
                                'class' => 'btn btn-success',
                                'style' => 'margin-top: 10px;',
                            ]) ?>
            </div>
        <?php endforeach; ?>

    </div>
</div>
