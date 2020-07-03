<?php

use common\components\GridView;
use common\models\DetailGalleryArticle;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle DetailGalleryArticle */

$this->title = Yii::t('app', 'Main Category');
?>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- shop -->
                <?php foreach ($mainCategories as $mainCategory) : ?>
                    <div class="col-md-4 col-xs-2">
                        <div class="shop">
                            <div class="shop-img">
                                <?php if ($mainCategory->category_photo != null) : ?>
                                    <?= Html::img($mainCategory::mainCategoryImagePath($mainCategory->category_photo), ['style' => 'width:100%;height: 250px']) ?>
                                <?php else: ?>
                                    <?= Html::a('test', 'test', ['style' => "padding-top: 245px;"]) ?>
                                <?php endif; ?>
                            </div>
                            <div class="shop-body">
                                <h3><?= $mainCategory->category_name ?><br>Collection</h3>
                                <?= Html::a(Yii::t('app', 'See More') . ' ' . '<i class="fa fa-arrow-circle-right"></i>', [
                                    'site/main-category',
                                    'mainCategoryId' => $mainCategory->id,
                                ], [
                                                'class' => 'cta-btn',
                                            ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- /shop -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->


</div>
