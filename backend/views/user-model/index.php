<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
//use common\models\auth\AuthItem;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchModel\UserModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'User Models');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create new User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'options'      => [
                                 'id'    => 'permission_grid',
                                 'style' => 'overflow: auto; word-wrap: break-word;',
                             ],
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'username',
                                 'company_name',
                                 'email:email',
                                /* [
                                     'filter'    => Html::activeDropDownList($searchModel, 'role', AuthItem::getRoleList(), [
                                         'class'  => 'form-control',
                                         'prompt' => Yii::t('app', 'alle Rollen'),
                                     ]),
                                     'label'     => Yii::t('app', 'Rolle'),
                                     'attribute' => 'role',
                                     'value'     => function ($model) {
                                         return Html::encode($model->getRole());
                                     },
                                     'format'    => 'raw',
                                 ],*/
                                 ['class' => 'common\components\ActionColumn'],
                             ],
                         ]); ?>


</div>
