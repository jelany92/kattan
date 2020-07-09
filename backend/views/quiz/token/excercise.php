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

<?php
$no = 1;

foreach ($models as $model) : ?>
    <div class="panel-group" id="accordion_<?= $model->id ?>">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?= $model->id ?>"><?= $model->question ?></a>
                </h3>
            </div>
            <div id="<?= $model->id ?>" class="panel-collapse collapse in">
                <div class="panel-body">
                    <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                          'name'    => $model->id . '[student_answer]',
                                                                                          'value'   => 'A',
                                                                                          'uncheck' => null,
                                                                                      ])->label($model->answer_a) ?>
                    <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                          'name'    => $model->id . '[student_answer]',
                                                                                          'value'   => 'B',
                                                                                          'uncheck' => null,
                                                                                      ])->label($model->answer_b) ?>
                    <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                          'name'    => $model->id . '[student_answer]',
                                                                                          'value'   => 'C',
                                                                                          'uncheck' => null,
                                                                                      ])->label($model->answer_c) ?>
                    <?= $form->field($modelForm[$model->id], 'student_answer')->radio([
                                                                                          'name'    => $model->id . '[student_answer]',
                                                                                          'value'   => 'D',
                                                                                          'uncheck' => null,
                                                                                      ])->label($model->answer_d) ?>
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
