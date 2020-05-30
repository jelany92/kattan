<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $articleInfo \common\models\ArticleInfo */
$this->registerAssetBundle('backend\assets\BookGallery');
?>
<div class="body">

    <h1><?= Yii::t('app', 'Articles') ?></h1>
    <br>

    <div class="row">
        <?php foreach ($articleInfo as $articleIDetails) : ?>
            <div class="books-view col-md-3">
                <?php
                $filesPhotoPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryArticle'] . DIRECTORY_SEPARATOR . $articleIDetails->article_photo;
                ?>
                <?= Html::img($filesPhotoPath, ['style' => 'width:255px;height: 330px']) ?>
                <br>
                <h3><?= $articleIDetails->article_name_ar ?></h3>

                <?= Html::a(Yii::t('app', 'Details'), [
                    'article-info/view',
                    'id' => $articleIDetails->id,
                ], [
                                'class' => 'btn btn-info',
                                'style' => 'margin-top: 10px;',
                            ]) ?>
                <?= Html::a(Yii::t('app', 'Download'), [
                    'detail-gallery-article/download',
                    'id' => $articleIDetails->id,
                ], [
                                'class' => 'btn btn-success',
                                'style' => 'margin-top: 10px;',
                            ]) ?>
            </div>
            <br>
        <?php endforeach; ?>

        <div class="center-block">
        <?= \common\components\LinkPager::widget([
                                                     'pagination' => $pages,
                                                 ]); ?>
        </div>

    </div>
    <br>
</div>
