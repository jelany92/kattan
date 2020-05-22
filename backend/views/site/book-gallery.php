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
                <?php $filesPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPhoto'] . DIRECTORY_SEPARATOR . $detailGalleryArticle->bookGalleries->book_photo; ?>
                <?= Html::img($filesPath, ['style' => 'width:255px;height: 330px']) ?>
                <?= Html::a(Yii::t('app', 'Details'), [
                    'detail-gallery-article/view',
                    'id' => $detailGalleryArticle->id,
                ], [
                                'class' => 'btn btn-info',
                                'style' => 'margin-top: 10px;',
                            ]) ?>
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
