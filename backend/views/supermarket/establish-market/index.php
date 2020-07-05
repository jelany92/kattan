<?php

use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\EstablishMarketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Establish Markets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="establish-market-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Establish Market'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],

                                 'amount',
                                 'reason',
                                 'selected_date',

                                 [
                                     'class'    => 'common\components\ActionColumn',
                                     'template' => '{update} {delete}',
                                 ],
                             ],
                         ]); ?>


</div>
