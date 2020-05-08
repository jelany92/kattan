<?php

use kartik\icons\Icon;
use yii\bootstrap4\Tabs;

/* @var $model common\models\UserStamm */
?>
<?= Tabs::widget([
                     'options' => ['id' => 'customer_nav'],
                     'items'   => [
                         [
                             'label'       => Icon::show('list-alt') . ' ' . Yii::t('app', 'معلومات الشهر'),
                             'linkOptions' => ['class' => 'tab-link'],
                             'active'      => Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'month-view',
                             'url'         => Yii::$app->urlManager->createUrl([
                                                                                   'site/month-view',
                                                                                   'year'  => $year,
                                                                                   'month' => $month,
                                                                               ]),
                             'encode'      => false,
                         ],
                         [
                             'label'       => Icon::show('list-alt') . ' ' . Yii::t('app', 'الدخل'),
                             'linkOptions' => ['class' => 'tab-link'],
                             'active'      => Yii::$app->controller->id == 'statistic' && Yii::$app->controller->action->id == 'month-income',
                             'url'         => Yii::$app->urlManager->createUrl([
                                                                                   'statistic/month-income',
                                                                                   'year'  => $year,
                                                                                   'month' => $month,
                                                                               ]),
                             'encode'      => false,
                         ],
                         [
                             'label'       => Icon::show('users') . ' ' . Yii::t('app', 'شراء بضاعة'),
                             'linkOptions' => ['class' => 'tab-link'],
                             'url'         => Yii::$app->urlManager->createUrl([
                                                                                   'statistic/month-purchases',
                                                                                   'year'  => $year,
                                                                                   'month' => $month,
                                                                               ]),
                             'active'      => Yii::$app->controller->id == 'statistic' && Yii::$app->controller->action->id == 'month-purchases',
                             'encode'      => false,
                         ],
                         [
                             'label'       => Icon::show('users') . ' ' . Yii::t('app', 'مجموع شراء بضاعة'),
                             'linkOptions' => ['class' => 'tab-link'],
                             'url'         => Yii::$app->urlManager->createUrl([
                                                                                   'statistic/month-purchases-group',
                                                                                   'year'  => $year,
                                                                                   'month' => $month,
                                                                               ]),
                             'active'      => Yii::$app->controller->id == 'statistic' && Yii::$app->controller->action->id == 'month-purchases-group',
                             'encode'      => false,
                         ],
                         [
                             'label'       => Icon::show('users') . ' ' . Yii::t('app', 'نفقات المحل'),
                             'linkOptions' => ['class' => 'tab-link'],
                             'url'         => Yii::$app->urlManager->createUrl([
                                                                                   'statistic/month-market-expense',
                                                                                   'year'  => $year,
                                                                                   'month' => $month,
                                                                               ]),
                             'active'      => Yii::$app->controller->id == 'statistic' && Yii::$app->controller->action->id == 'month-market-expense',
                             'encode'      => false,
                         ],
                     ],
                 ]); ?>
<br>
