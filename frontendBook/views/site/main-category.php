<?php

use yii\bootstrap4\Html;
use common\models\DetailGalleryArticle;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle DetailGalleryArticle */

$this->title = 'Book Gallery';
?>

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title"><?= Yii::t('app', 'New Book') ?></h3>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
                <div class="col-md-3" style="padding-bottom: 50px;">
                    <!-- product -->
                    <div class="product">
                        <div class="product-img">
                            <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
                                <?= Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), ['style' => 'width:263px;height: 325px']) ?>
                            <?php else: ?>
                                <?= Html::a('test', 'test', ['style' => "padding-top: 245px;"]) ?>
                            <?php endif; ?>
                            <div class="product-label">
                                <span class="new">NEW</span>
                            </div>
                        </div>
                        <div class="product-body">
                            <p class="product-category"><?= $detailGalleryArticle->mainCategory->category_name ?></p>
                            <h3 class="product-name"><?= Html::a($detailGalleryArticle->article_name_ar, ['book-info/book-details', 'detailGalleryArticleId' => $detailGalleryArticle->id]); ?></a></h3>
                        </div>
                        <div class="add-to-cart">
                            <?= Html::a(Yii::t('app', 'Read'), $detailGalleryArticle->link_to_preview, [
                                'class'  => 'add-to-cart-btn',
                                'target' => '_blank',
                            ]) ?>
                        </div>
                        <!-- /product -->
                    </div>
                </div>
                <!-- Products tab & slick -->
            <?php endforeach; ?>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->