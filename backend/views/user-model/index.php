<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchModel\UserModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'User Models');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User Model'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'username',
                                 'company_name',
                                 'email:email',
                                 ['class' => 'common\components\ActionColumn'],
                             ],
                         ]); ?>


</div>
