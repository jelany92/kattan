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
//  $form->field($modelCreateUser, 'password')->radioList(UserSubDetailForm::getSetPasswordList(), [
//            'id' => 'password',
//        ])
foreach ($models as $model):
    ?>
    <div class="col-md-12 column">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= $no . '. ' . $model->question ?><?php
                    /* @var $this yii\web\View */

                    use yii\bootstrap4\Html;
                    use yii\widgets\ActiveForm;

                    $this->title                   = 'Excercise';
                    $this->params['breadcrumbs'][] = $this->title;
                    ?>

                    <?php $isExpanded = true; ?>
                    <?php $isComplete = false; ?>
                    <?php $form = ActiveForm::begin([
                                                        'options' => [
                                                            'style' => 'padding-right: -100px;',
                                                        ],
                                                    ]) ?>
                    <?php foreach ($excercise as $key => $ex) : ?>

                        <div class="card mb-2">
                            <h4 class="card-header category-card <?= $isComplete ? 'alert-success' : '' ?>">
                                <a data-toggle="collapse" href="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapse<?= $key ?>" id="heading<?= $key ?>" class="d-block">
                                    <?= Html::encode($ex['question']) ?>
                                </a>
                            </h4>
                            <div id="collapse<?= $key ?>" class="collapse <?= ($isExpanded) ? 'in show' : '' ?>" aria-labelledby="heading<?= $key ?>" data-parent="#accordion">
                                <div class="card-body">
                                    <?php $arr = [
                                        $ex['answer_a'],
                                        $ex['answer_b'],
                                        $ex['answer_c'],
                                        $ex['answer_d'],
                                    ]; ?>

                                    <?= $form->field($models, 'student_answer')->radioList($arr, [
                                        'id'     => 'password',
                                        'inline' => true,
                                        'style'  => 'margin-right: 20px;',
                                    ])->label('<h3>' . $ex['question'] . '</h3>', ['style' => 'padding-right: -10px;']); ?>


                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                    <?php
                    //  $form->field($modelCreateUser, 'password')->radioList(UserSubDetailForm::getSetPasswordList(), [
                    //            'id' => 'password',
                    //        ])
                    ?>

                </h3>
            </div>
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
    <?php
    $no++;
endforeach;
?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>