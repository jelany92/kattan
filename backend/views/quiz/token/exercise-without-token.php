<?php

/* @var $this yii\web\View */
/* @var $exercises \backend\models\quiz\Excercise */

/* @var $modelQuizAnswerForm \backend\models\quiz\QuizAnswerForm */

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

$this->title                   = Yii::t('app', 'Exercise');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>

<?php
$no         = 1;
$isExpanded = true;

foreach ($exercises as $exercise) : ?>
    <?php $answers = [
        'answer_a' => $exercise['answer_a'],
        'answer_b' => $exercise['answer_b'],
        'answer_c' => $exercise['answer_c'],
        'answer_d' => $exercise['answer_d'],
    ] ?>
    <div class="panel-group" id="accordion_<?= $exercise['id'] ?>">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?= $exercise['id'] ?>" aria-expanded="true" aria-controls="collapse<?= $exercise['id'] ?>" id="heading<?= $exercise['id'] ?>" class="d-block"><?= $exercise['question'] ?></a>
                </h3>
            </div>
            <div id="<?= $exercise['id'] ?>" class="panel-collapse collapse <?= ($isExpanded) ? 'in' : '' ?>" role="tab" aria-labelledby="heading-<?= $exercise['id'] ?>" data-parent="#accordion">
                <div class="panel-body">
                    <?= $form->field($modelQuizAnswerForm, 'answer')->radioList($answers, [
                        'name'      => 'Answers[' . $exercise['id'] . ']',
                        'separator' => '<br>',
                    ])->label(false) ?>

                </div>
            </div>
        </div>
    </div>
    <?php
    $no++;
    $isExpanded = false;
endforeach;
?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

