<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;

$this->title                   = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$this->registerAssetBundle('backend\assets\Log');
?>
<div class="login-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('app', 'Please fill out the following fields to login') ?> : </p>

    <div>
        <?php $form = ActiveForm::begin([
                                            'type' => ActiveForm::TYPE_HORIZONTAL,
                                        ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group text-xl-center">
            <?= Html::submitButton('Login', [
                'class' => 'btn btn-primary ',
                'name'  => 'login-button',
            ]) ?>
            <?= Html::a(Yii::t('app', 'Create Customer'), ['user-model/create'], ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
