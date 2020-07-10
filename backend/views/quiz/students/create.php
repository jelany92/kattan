<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \backend\models\quiz\Students */

$this->title = Yii::t('app', 'Create Students');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="students-crud-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
