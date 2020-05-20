<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DetailGalleryArticle */
/* @var $modelGalleryBookForm common\models\GalleryBookForm */
/* @var $fileUrlsPhoto string */
/* @var $fileUrlsPdf string */
/* @var $photoFileList array */
/* @var $pdfFileList array */

$this->title                   = Yii::t('app', 'Create Detail Gallery Article');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Detail Gallery Articles'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail-gallery-article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'                => $model,
        'modelGalleryBookForm' => $modelGalleryBookForm,
        'fileUrlsPhoto'        => $fileUrlsPhoto,
        'fileUrlsPdf'          => $fileUrlsPdf,
        'photoFileList'        => $photoFileList,
        'pdfFileList'          => $pdfFileList,
    ]) ?>

</div>
