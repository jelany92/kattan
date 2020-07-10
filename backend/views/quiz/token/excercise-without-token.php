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
//var_dump($exercices);die();

foreach ($excercise as $exercices) : ?>
    <?php $answers = [
        'answer_a' => $exercices['answer_a'],
        'answer_b' => $exercices['answer_b'],
        'answer_c' => $exercices['answer_c'],
        'answer_d' => $exercices['answer_d'],
    ] ?>
    <div class="panel-group" id="accordion_<?= $exercices['id'] ?>">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?= $exercices['id'] ?>"><?= $exercices['question'] ?></a>
                </h3>
            </div>
            <div id="<?= $exercices['id'] ?>" class="panel-collapse collapse in">
                <div class="panel-body">
                    <?= $form->field($modelQuizAnswerForm, 'answer')->radioList($answers, [
                        'name' => 'Answers[' . $exercices['id'] . ']',
                        //'separator' => '<br>',
                    ])->label(false) ?>

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