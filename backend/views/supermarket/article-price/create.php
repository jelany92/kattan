<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticlePrice */
/* @var $categoryList array */
/* @var $articleList  array */

$this->title = Yii::t('app', 'Create Article Price');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Article Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'       => $model,
        'articleList' => $articleList,
    ]) ?>

</div>
