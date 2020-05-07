<?php

use common\models\ArticleInfo;

$articleInfo = ArticleInfo::find()->all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | Kattan-Shopper</title>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
</head><!--/head-->
<body>
<?= $this->render('slider-offer') ?>
<section>
    <div class="container">
        <div class="row">
            <?= $this->render('left-nav') ?>
            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Features Items</h2>
                    ?>
                    <?php foreach ($articleInfo as $article) : ?>
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <?php $photoPath = $article->article_photo; ?>
                                        <img src="images/article_file/<?= $photoPath ?>" alt=""/>
                                        <h2>$<?= $article->article_buy_price ?></h2>
                                        <h3><?= $article->article_name_ar ?></h3>
                                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                    </div>
                                    <div class="product-overlay">
                                        <div class="overlay-content">
                                            <h2><?= $article->article_buy_price ?></h2>
                                            <p><?= $article->article_name_ar ?></p>
                                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div><!--features_items-->
                <?= $this->render('side-nav') ?>
                <?= $this->render('offer') ?>
            </div>
        </div>
    </div>
</section>
</body>
</html>