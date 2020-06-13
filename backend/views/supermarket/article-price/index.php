<?php

use yii\bootstrap4\Html;
use common\components\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ArticleInfo;
use kartik\form\ActiveForm;
use common\models\ArticlePrice;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchModel\ArticlePriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Article Prices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-price-index">

    <?php $form = ActiveForm::begin([
        'type'   => ActiveForm::TYPE_HORIZONTAL,
        'action' => ['index'],
        'method' => 'post',
    ]); ?>
    <?= $form->field($searchModel, 'articleName') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'بحث'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'الغاء'), ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a(Yii::t('app', 'اعادة'), ['index'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', Yii::t('app', 'Article Price Export')), [
            'article-price/export',
        ], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'article_info_id',
                'filter'    => Select2::widget([
                    'name'  => 'ArticlePriceSearch[article_info_id]',
                    'model' => $searchModel,
                    'value' => $searchModel->article_info_id,
                    'data'  => ArrayHelper::map(ArticleInfo::find()->andWhere(['company_id' => Yii::$app->user->id])->all(), 'id', 'article_name_ar'),
                ]),
                'value'     => function ($model) {
                    if ($model instanceof ArticlePrice)
                    {
                        return Html::a($model->articleInfo->article_name_ar, [
                            'article-info/view',
                            'id' => $model->articleInfo->id,
                        ]);
                    }
                    return $model['article_name_ar'];
                },
                'format'    => 'raw',
            ],
            [
                'label'  => Yii::t('app', 'Quantity'),
                'value'  => function ($model) {
                    if ($model instanceof ArticlePrice)
                    {
                        $quantity = $model->articleInfo->article_quantity . ' ' . $model->articleInfo->article_unit;
                    }
                    else
                    {
                        $quantity = $model['article_quantity'] . ' ' . $model['article_unit'];
                    }
                    return $quantity;
                },
                'format' => 'raw',
            ],
            'article_total_prise',
            'article_prise_per_piece',
            [
                'label'  => Yii::t('app', 'Rechnung File'),
                'value'  => function ($model) {
                    $url = [];
                    if ($model instanceof ArticlePrice)
                    {
                        foreach ($model->purchaseInvoices->invoicePhotos as $file)
                        {
                            $filesPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryMail'] . DIRECTORY_SEPARATOR . $file->photo_path;
                            $url[]     = Html::a($model->purchaseInvoices->seller_name, $filesPath, ['target' => '_blank']);
                        }
                    }
                    // noch nicht fertig
                    else
                    {
                        $filesPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryMail'] . DIRECTORY_SEPARATOR . $model['photo_path'];
                        $url[]     = Html::a($model['seller_name'], $filesPath, ['target' => '_blank']);
                    }
                    return implode("<br>", $url);
                },
                'format' => 'raw',

            ],
            'selected_date',

            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>

</div>
