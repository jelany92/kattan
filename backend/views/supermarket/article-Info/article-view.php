<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $dataProvider \common\models\ArticleInfo */
$this->registerAssetBundle('backend\assets\BookGallery');
?>
<div class="body">

    <h1><?= Yii::t('app', 'اصنع مكتبتك الخاصة') ?></h1>
    <br>

    <div class="row">
        <?php foreach ($dataProvider as $detailGalleryArticle) : ?>
            <div class="books-view col-md-3">
                <?php
                $filesPhotoPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryArticle'] . DIRECTORY_SEPARATOR . $detailGalleryArticle->article_photo;
                ?>
                <?= Html::img($filesPhotoPath, ['style' => 'width:255px;height: 330px']) ?>
                <br>
                <h3><?= $detailGalleryArticle->article_name_ar ?></h3>

                <?= Html::a(Yii::t('app', 'Details'), [
                    'article-info/view',
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
            <br>
        <?php endforeach; ?>
    </div>
    <br>
</div>
