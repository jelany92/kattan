<?php

use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\CapitalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Capitals');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="capital-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Capital'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'amount',
            'selected_date',
            'status',

            [
                'class'    => 'common\components\ActionColumn',
                'template' => '{update} {delete}',
            ],        ],
    ]); ?>


</div>
