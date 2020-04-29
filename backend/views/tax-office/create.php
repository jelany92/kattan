<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TaxOffice */

$this->title = Yii::t('app', 'Create Tax Office');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tax Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tax-office-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
