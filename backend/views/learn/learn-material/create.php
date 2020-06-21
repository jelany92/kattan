<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\learn\LearnMaterial */

$this->title = Yii::t('app', 'Create Learn Material');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Learn Materials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learn-material-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
