<?php

use yii\bootstrap4\Html;
/* @var $this yii\web\View */
/* @var $model common\models\ArticlePrice */
/* @var $articleList  array */

$this->title = Yii::t('app', 'Update Article Price: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Article Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="article-price-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'       => $model,
        'articleList' => $articleList,
    ]) ?>

</div>
