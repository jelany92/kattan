<?php

use yii\bootstrap4\Html;
use common\components\GridView;
use backend\models\Purchases;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\PurchasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $show bool */

$this->title                   = Yii::t('app', 'Purchases');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchases-index">

    <h1><?= Html::encode($this->title) . ': ' . Purchases::sumResultPurchases()['result'] ?></h1>
    <?php if ($show == false) : ?>

        <?php $form = ActiveForm::begin([
            'type'   => ActiveForm::TYPE_HORIZONTAL,
            'action' => ['index'],
            'method' => 'post',
        ]); ?>

        <?= $form->field($model, 'reason') ?>
        <?= $form->field($model, 'from')->widget(DatePicker::class, [
            'options'       => ['placeholder' => 'Enter event time ...'],
            'pluginOptions' => [
                'autoclose'    => true,
                'showMeridian' => false,
                'endDate'      => '+0d',
                'format'       => 'yyyy-mm-dd',
            ],
        ]) ?>
        <?= $form->field($model, 'to')->widget(DatePicker::class, [
            'options'       => ['placeholder' => 'Enter event time ...'],
            'pluginOptions' => [
                'autoclose'    => true,
                'showMeridian' => false,
                'endDate'      => '+0d',
                'format'       => 'yyyy-mm-dd',
            ],
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'بحث'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('app', 'الغاء'), ['class' => 'btn btn-outline-secondary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php else: ?>
        <h1><?= Yii::t('app', 'مجموع ما تم بحث عنه<br> ') . $model->reason . ': ' . $result['result'] ?></h1>
    <?php endif; ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Purchases'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', Yii::t('app', 'Purchases export')), [
            'purchases/export',
        ], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            'reason',
            'purchases',
            'selected_date',
            [
                'class'    => 'common\components\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>
