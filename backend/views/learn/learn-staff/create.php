<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\learn\LearnStaff */

$this->title = Yii::t('app', 'Create Learn Staff');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Learn Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learn-staff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
