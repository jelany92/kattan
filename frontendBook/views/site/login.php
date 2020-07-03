<?php

/* @var $this yii\web\View */
/* @var $form \kartik\form\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\bootstrap4\Html;
use yii\bootstrap\ActiveForm;

$this->title                   = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
            <?php $form = ActiveForm::begin([
                                                'id' => 'login-form',
                                            ]); ?>
            <form class="login100-form validate-form">
					<span class="login100-form-title p-b-55">
						Login
					</span>
                <!-- <div class="wrap-input100 validate-input m-b-16" data-validate="Password is required">
                     <input class="input100" type="password" name="pass" placeholder="Name">
                     <span class="focus-input100"></span>
                 </div>-->
                <div>
                    <?= $form->field($model, 'username')->textInput([
                                                                        'autofocus'   => true,
                                                                        'class'       => 'input100',
                                                                        'placeholder' => $model->attributeLabels()['username'],
                                                                    ])->label(false) ?>
                </div>

                <div>
                    <?= $form->field($model, 'password')->textInput([
                                                                        'autofocus'   => true,
                                                                        'class'       => 'input100',
                                                                        'placeholder' => $model->attributeLabels()['password'],
                                                                    ])->label(false) ?>
                </div>

                <?= $form->field($model, 'rememberMe')->checkbox([
                                                                     'class' => 'label-checkbox100',
                                                                     'for'   => 'ckb1',
                                                                 ]) ?>

                <div class="container-login100-form-btn p-t-25">
                    <?= Html::submitButton('Login', [
                        'class' => 'login100-form-btn',
                        'name'  => 'login-button',
                    ]) ?>
                </div>

                <div class="text-center w-full p-t-42 p-b-22">
						<span class="txt1">
							<?= Yii::t('app', 'Or login with') ?>
						</span>
                </div>
                <div>
                    <?= Html::a('<i class="fa fa-facebook-official"></i>' . Yii::t('app', 'Facebook'), '', [
                        'class' => 'btn-face m-b-10',
                    ]) ?>
                </div>

                <div>
                    <?= Html::a(Html::img(Yii::getAlias('frontendBook') . '/web/images/home/icons/icon-google.png', [
                        'alt' => "GOOGLE",
                    ]), [''], [
                                    'class' => 'btn-face m-b-10',
                                ]) ?>
                </div>

                <div class="text-center w-full p-t-115">
						<span class="txt1">
                            <?= Yii::t('app', 'Not a member?') ?>
						</span>

                    <?= Html::a(Yii::t('app', 'Sign up now'), [''], [
                        'class' => 'txt1 bo1 hov1',
                    ]) ?>
                </div>
            </form>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

