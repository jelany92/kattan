<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title                   = 'Excercise';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i>Saved!</h4>
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php
$no = 1;

foreach ($models as $model):?>
    <div class="col-md-12 column">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= $no . '. ' . $model->question ?>
                </h3>
            </div>
            <div class="panel-body">
                <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                      'name'    => $model->id . '[student_answer]',
                                                                                      'value'   => 'answer_a',
                                                                                      'uncheck' => null,
                                                                                  ])->label($model->answer_a) ?>
                <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                      'name'    => $model->id . '[student_answer]',
                                                                                      'value'   => 'answer_b',
                                                                                      'uncheck' => null,
                                                                                  ])->label($model->answer_b) ?>
                <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                      'name'    => $model->id . '[student_answer]',
                                                                                      'value'   => 'answer_c',
                                                                                      'uncheck' => null,
                                                                                  ])->label($model->answer_c) ?>
                <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                      'name'    => $model->id . '[student_answer]',
                                                                                      'value'   => 'answer_d',
                                                                                      'uncheck' => null,
                                                                                  ])->label($model->answer_d) ?>
            </div>
        </div>
    </div>
    <?php
    $no++;
endforeach;
?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"> <?= $no . '. ' . $model->question ?></a>
            </h4>
        </div>
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Collapsible Group 1</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
