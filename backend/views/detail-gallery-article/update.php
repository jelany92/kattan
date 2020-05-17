<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $modelGalleryBookForm common\models\GalleryBookForm */
/* @var $fileUrlsPhoto string */
/* @var $fileUrlsPdf string */

$this->title                   = Yii::t('app', 'Update Detail Gallery Article: {name}', [
    'name' => $modelGalleryBookForm->article_name_ar,
]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Detail Gallery Articles'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->id,
    'url'   => [
        'view',
        'id' => $model->id,
    ],
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="detail-gallery-article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'         => $modelGalleryBookForm,
        'fileUrlsPhoto' => $fileUrlsPhoto,
        'fileUrlsPdf'   => $fileUrlsPdf,
    ]) ?>

</div>
