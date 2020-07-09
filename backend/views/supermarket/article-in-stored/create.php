<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleInStored */

$this->title = Yii::t('app', 'Create Article In Stored');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Article In Storeds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-in-stored-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
