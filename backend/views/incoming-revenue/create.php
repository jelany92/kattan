<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\IncomingRevenue */

$this->title = Yii::t('app', 'Create Incoming Revenue');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Incoming Revenues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-revenue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
