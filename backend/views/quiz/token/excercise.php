<?php
/* @var $this yii\web\View */

use yii\bootstrap4\Html;
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

<?php $isExpanded = true; ?>
<?php $isComplete = false; ?>

<?php
$no = 1;
//  $form->field($modelCreateUser, 'password')->radioList(UserSubDetailForm::getSetPasswordList(), [
//            'id' => 'password',
//        ])


foreach ($models as $model):
    ?>
    <div class="col-md-12 column">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a data-toggle="collapse" href="#collapse<?= $model->id ?>" aria-expanded="true" aria-controls="collapse<?= $model->id ?>" id="heading<?= $model->id ?>" class="d-block">
                        <?= $no . '. ' . $model->question ?>
                    </a>
                </h3>
            </div>
            <div id="collapse<?= $model->id ?>" class="collapse <?= ($isExpanded) ? 'in show' : '' ?>" aria-labelledby="heading<?= $model->id ?>" data-parent="#accordion">
                <div class="card-body">
                    <div class="panel-body">
                        <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                              'name'    => $model->id,
                                                                                              'value'   => 'A',
                                                                                              'uncheck' => null,
                                                                                          ])->label($model->answer_a) ?>
                        <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                              'name'    => $model->id . '[student_answer]',
                                                                                              'value'   => 'B',
                                                                                              'uncheck' => null,
                                                                                          ])->label($model->answer_c, [
                            ['style' => 'margin-left: 50px;'],
                        ]) ?>
                        <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                              'name'    => $model->id . '[student_answer]',
                                                                                              'value'   => 'C',
                                                                                              'uncheck' => null,
                                                                                          ])->label($model->answer_c, [
                            'options' => [
                                'style' => 'margin-left: 50px;',
                            ],
                        ]) ?>
                        <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                              'name'    => $model->id . '[student_answer]',
                                                                                              'value'   => 'D',
                                                                                              'uncheck' => null,
                                                                                          ])->label($model->answer_d) ?>
                    </div>
                </div>
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