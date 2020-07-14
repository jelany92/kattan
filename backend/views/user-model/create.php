<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserModel */

$this->title = Yii::t('app', 'Create new User');
if (Yii::$app->user->can('user-model.view')
{
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Models'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
