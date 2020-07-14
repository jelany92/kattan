<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\learn\LearnMaterial */

$this->title                   = $model->learnStaff->staff_name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Learn Materials'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="learn-material-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('*.*')) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Update'), [
                'update',
                'id' => $model->id,
            ], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), [
                'delete',
                'id' => $model->id,
            ], [
                            'class' => 'btn btn-danger',
                            'data'  => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method'  => 'post',
                            ],
                        ]) ?>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
                               'model'      => $model,
                               'attributes' => [
                                   [
                                       'attribute' => Yii::t('app', 'Staff Name'),
                                       'value'     => function ($model) {
                                           return $model->learnStaff->staff_name;
                                       },
                                       'format'    => 'raw',
                                   ],
                                   'material_name',
                                   'material_link:url',
                               ],
                           ]) ?>

</div>
