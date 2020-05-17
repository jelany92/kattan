<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DetailGalleryArticle */
/* @var $fileUrlsPhoto string */
/* @var $fileUrlsPdf string */

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
        'model'         => $model,
        'fileUrlsPhoto' => $fileUrlsPhoto,
        'fileUrlsPdf'   => $fileUrlsPdf,
    ]) ?>

</div>
