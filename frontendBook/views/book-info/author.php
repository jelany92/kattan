<?php

use common\components\GridView;
use common\models\DetailGalleryArticle;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle DetailGalleryArticle */

$this->title = Yii::t('app', 'Author');
?>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'options'      => [
                                 'id'    => 'permission_grid',
                                 'style' => 'overflow: auto; word-wrap: break-word;',
                             ],
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'name',
                             ],
                         ]); ?>


</div>
