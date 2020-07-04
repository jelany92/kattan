<?php

use yii\bootstrap4\Html;
use common\models\DetailGalleryArticle;

/* @var $this yii\web\View */
/* @var $detailGalleryArticle \common\models\DetailGalleryArticle */

$this->title = $detailGalleryArticle->article_name_ar;
$subcategory = [];
foreach ($detailGalleryArticle->gallerySaveCategory as $gallerySaveCategory)
{
    $subcategory[] = $gallerySaveCategory->subcategory->subcategory_name;
}
?>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>

    <div class="col-md-3">
        <?= Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), ['style' => 'width:100%;height: 290px;margin-bottom: 50px;']) ?>
    </div>
    <br>

    <!-- SECTION -->
    <div class="row col-md-4" style="margin-left: 45px;">
        <h3><?= Yii::t('app', 'Book Name') ?></h3>
        <h3><?= Yii::t('app', 'Section') ?></h3>
        <h3><?= Yii::t('app', 'subcategory') ?></h3>
        <h3><?= Yii::t('app', 'The owner of the book') ?></h3>
        <h3><?= Yii::t('app', 'Date added') ?></h3>
        <h3><?= Yii::t('app', 'Read') ?></h3>
    </div>
    <!-- /SECTION -->
    <!-- SECTION -->
    <div class="row col-md-5">
        <h3><?= $this->title ?></h3>
        <h3><?= $detailGalleryArticle->mainCategory->category_name ?></h3>
        <h3><?= implode(' ', $subcategory) ?></h3>
        <h3><?= $detailGalleryArticle->bookGalleries->bookAuthorName->name ?></h3>
        <h3><?= isset($detailGalleryArticle->selected_date) ? $detailGalleryArticle->selected_date : '<br>' ?></h3>
        <h3><?= Html::a(Yii::t('app', 'Read Online'), $detailGalleryArticle->link_to_preview, [
                'class'  => 'add-to-cart-btn',
                'target' => '_blank',
            ]) ?></h3>
    </div>
    <!-- /SECTION -->
</div>
