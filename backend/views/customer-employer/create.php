<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerEmployer */

$this->title = Yii::t('app', 'Create New Customer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'New Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-customer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
