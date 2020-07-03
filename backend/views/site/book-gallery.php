<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle \common\models\DetailGalleryArticle */
$this->registerAssetBundle('backend\assets\BookGallery');
?>
<div class="body">
    <!--    <?php /*if (Yii::$app->user->id != 3) : */ ?>
        <?php /*if (Yii::$app->user->id != 2) : */ ?>
            <p>
                <? /*= Html::a(Yii::t('app', 'Demo Data'), ['demo-data'], ['class' => 'btn btn-success']) */ ?>
            </p>
            <br>
            <br>
        <?php /*endif; */ ?>
    --><?php /*endif; */ ?>
    <div class="text-xl-center">
        <h1><?= Yii::t('app', 'مكتبتي') ?></h1>
    </div>
    <br>

    <div class="row">
        <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
            <div class="books-view col-md-3">
                <?php
                $filesPhotoPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPhoto'] . DIRECTORY_SEPARATOR . $detailGalleryArticle->bookGalleries->book_photo;
                $filePath       = Yii::getAlias('backend') . DIRECTORY_SEPARATOR . 'web' . $filesPhotoPath;
                $filesPdfPath   = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPdf'] . DIRECTORY_SEPARATOR . $detailGalleryArticle->bookGalleries->book_pdf;
                $filesPdfRoot   = isset($detailGalleryArticle->bookGalleries->book_pdf) ? $detailGalleryArticle->bookGalleries->getAbsolutePath(Yii::$app->params['uploadDirectoryBookGalleryPdf'], $detailGalleryArticle->bookGalleries->book_pdf) : '';
                ?>
                <?= Html::a(Html::img($filesPhotoPath, ['style' => 'width:100%;height: 330px']), [
                    'detail-gallery-article/view',
                    'id' => $detailGalleryArticle->id,
                ]) ?>
                <div class="photo-title">
                    <h3><?= Html::a($detailGalleryArticle->article_name_ar, [
                            'detail-gallery-article/view',
                            'id' => $detailGalleryArticle->id,
                        ]) ?></h3>
                </div>
                <br>
            </div>
            <br>
        <?php endforeach; ?>
        <div class="center-block">
            <?= \common\components\LinkPager::widget([
                                                         'pagination' => $pages,
                                                     ]); ?>
        </div>
    </div>
</div>
