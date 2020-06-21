<?php

use common\models\MainCategory;

$categoryList = MainCategory::getMainCategoryList();
?>
<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            <?php foreach ($categoryList as $key => $category) : ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php if ('href' != 'site/category') :?>
                        <h4 class="panel-title"><a href="index.php/site/category?id=<?= $key ?>"> <?= $category ?></a></h4>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>