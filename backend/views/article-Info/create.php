<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleInfo */
/* @var $articleList array */

$this->title = Yii::t('app', 'Create Article Info');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Article Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'       => $model,
        'articleList' => $articleList,
    ]) ?>

</div>
