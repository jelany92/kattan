<?php

use common\components\GridView;
use common\models\DetailGalleryArticle;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $subcategory \common\models\Subcategory */

$this->title = Yii::t('app', 'Subcategory');
?>

<div class="container">
    <br>
    <!-- Products tab & slick -->
    <?php foreach ($subcategories as $subcategory) : ?>
        <h1><?= Html::encode($subcategory->subcategory_name) ?></h1>
        <div class="col-md-12">
            <div class="row">
                <div class="products-tabs">
                    <!-- tab -->
                    <div id="tab1" class="tab-pane active">
                        <div class="products-slick" data-nav="#<?= ($subcategory->id)?>">
                            <!-- product -->
                            <?php $modelDetailGalleryArticle = DetailGalleryArticle::find()->innerJoinWith('gallerySaveCategory')->andWhere(['subcategory_id' => $subcategory->id])->all(); ?>
                            <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
                                <div class="product">
                                    <div class="product-img">
                                        <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
                                            <?= Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), ['style' => 'width:255px;height: 300px']) ?>
                                        <?php else: ?>
                                            <?= Html::a('test', 'test', ['style' => "padding-top: 245px;"]) ?>
                                        <?php endif; ?>
                                        <div class="product-label">
                                            <span class="new">NEW</span>
                                        </div>
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category"><?= $detailGalleryArticle->mainCategory->category_name ?></p>
                                        <h3 class="product-name"><a href="#"><?= $detailGalleryArticle->article_name_ar; ?></a></h3>
                                        <h4 class="product-price">free
                                            <!--                                                <del class="product-old-price">$990.00</del>
                                            -->
                                        </h4>
                                    </div>
                                    <div class="add-to-cart">
                                        <?= Html::a(Yii::t('app', 'Read'), $detailGalleryArticle->link_to_preview, [
                                            'class'  => 'add-to-cart-btn',
                                            'target' => '_blank',
                                        ]) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- /product -->
                        </div>
                    </div>
                    <div id="<?= ($subcategory->id)?>" class="products-slick-nav"></div>
                </div>
                <!-- /tab -->
            </div>
        </div>
        <!-- Products tab & slick -->
    <?php endforeach; ?>
</div>
