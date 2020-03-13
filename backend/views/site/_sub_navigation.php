<?php

use common\models\UserBrowserInfo;
use kartik\icons\Icon;
use yii\bootstrap4\Tabs;

/* @var $model common\models\UserStamm */
?>
<?= Tabs::widget([
    'options' => ['id' => 'customer_nav'],
    'items'   => [
        [
            'label'       => Icon::show('list-alt') . ' ' . Yii::t('app', 'الدخل'),
            'linkOptions' => ['class' => 'tab-link'],
            'active'      => Yii::$app->controller->id == 'user-stamm' && Yii::$app->controller->action->id == 'view',
            'url'         => Yii::$app->urlManager->createUrl([
                'site/month-income',
                'year'  => $year,
                'month' => $month,
            ]),
            'encode'      => false,
        ],
        [
            'label'       => Icon::show('users') . ' ' . Yii::t('app', 'شراء بضاعة'),
            'linkOptions' => ['class' => 'tab-link'],
            /*   'url'         => Yii::$app->urlManager->createUrl([
                   'user-stamm/user',
                   'id' => $model->id,
               ]),*/
            'active'      => (Yii::$app->controller->id == 'user-stamm' && Yii::$app->controller->action->id == 'user') || (Yii::$app->controller->id == 'user-sub-detail' && Yii::$app->controller->action->id == 'view'),
            'encode'      => false,
        ],
        [
            'label'       => Icon::show('users') . ' ' . Yii::t('app', 'مصروفات المحل'),
            'linkOptions' => ['class' => 'tab-link'],
            /*   'url'         => Yii::$app->urlManager->createUrl([
                   'user-stamm/user',
                   'id' => $model->id,
               ]),*/
            'active'      => (Yii::$app->controller->id == 'user-stamm' && Yii::$app->controller->action->id == 'user') || (Yii::$app->controller->id == 'user-sub-detail' && Yii::$app->controller->action->id == 'view'),
            'encode'      => false,
        ],
        [
            'label'       => Icon::show('users') . ' ' . Yii::t('app', 'مدفوعات للمحل'),
            'linkOptions' => ['class' => 'tab-link'],
            /*   'url'         => Yii::$app->urlManager->createUrl([
                   'user-stamm/user',
                   'id' => $model->id,
               ]),*/
            'active'      => (Yii::$app->controller->id == 'user-stamm' && Yii::$app->controller->action->id == 'user') || (Yii::$app->controller->id == 'user-sub-detail' && Yii::$app->controller->action->id == 'view'),
            'encode'      => false,
        ],
        [
            'label'       => Icon::show('users') . ' ' . Yii::t('app', 'ناتج الدخل اليومي'),
            'linkOptions' => ['class' => 'tab-link'],
            /*   'url'         => Yii::$app->urlManager->createUrl([
                   'user-stamm/user',
                   'id' => $model->id,
               ]),*/
            'active'      => (Yii::$app->controller->id == 'user-stamm' && Yii::$app->controller->action->id == 'user') || (Yii::$app->controller->id == 'user-sub-detail' && Yii::$app->controller->action->id == 'view'),
            'encode'      => false,
        ],
    ],
]); ?>
<br>
