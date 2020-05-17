<?php

use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchModel\CustomerEmployerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'New Customers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-customer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create New Customer'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 [
                                     'attribute' => 'user.company_name',
                                     'label'     => Yii::t('app', 'Company Name'),
                                 ],
                                 'first_name',
                                 'last_name',
                                 'email:email',
                                 ['class' => 'common\components\ActionColumn'],
                             ],
                         ]); ?>


</div>
