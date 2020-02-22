<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;

$this->title                   = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login text-xl-center">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>
</div>
<div class="row">
    <div class="col-lg-6" style="padding-right: 40px;padding-left: -50px;margin-left: 300px">
        <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'id'   => 'login-form',
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group text-xl-center">
            <?= Html::submitButton('Login', [
                'class' => 'btn btn-primary ',
                'name'  => 'login-button',
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
