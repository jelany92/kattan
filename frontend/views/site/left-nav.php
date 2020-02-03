<?php

use common\models\Category;

$categoryList = Category::getCategoryList();
?>
<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            <?php foreach ($categoryList as $category) : ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a href="#"> <?= $category; ?></a></h4>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>