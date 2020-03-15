<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use backend\components\LanguageDropdown;

AppAsset::register($this);

function items($teams, $view)
{
    $items = [];

    foreach ($teams as $key => $team)
    {
        $items[] = [
            'label' => $team,
            'url'   => [
                $view,
                'id' => $key,
            ],
        ];
    }
    return $items;
}

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html <?= Yii::$app->language == 'ar' ? 'dir="rtl" ' . "lang=" . Yii::$app->language : "lang=" . Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl'   => Yii::$app->homeUrl,
            'options'    => ['class' => 'sticky-top navbar-expand-lg navbar-dark bg-dark ml-auto',],
        ]);
        $menuItems = [
            [
                'label' => 'Home',
                'url'   => ['/site/index'],
            ],
        ];
        if (Yii::$app->user->isGuest)
        {
            $menuItems[] = [
                'label' => 'Login',
                'url'   => ['/site/login'],
            ];
        }
        else
        {
            $teams       = \common\models\Category::getCategoryList();
            $menuItems   = [
                [
                    'label' => Yii::t('app', 'Categories'),
                    'items' => items($teams, '/category/view'),
                ],
                [
                    'label' => Yii::t('app', 'Merchandise'),
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Article'),
                            'url'   => ['/article-info/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Article Price'),
                            'url'   => ['/article-price/index'],
                        ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Market Information'),
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Capital'),
                            'url'   => ['/capital/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Purchase Invoices'),
                            'url'   => ['/purchase-invoices/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Incoming Revenues'),
                            'url'   => ['/incoming-revenue/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Purchases'),
                            'url'   => ['/purchases/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Market Expense'),
                            'url'   => ['/market-expense/index'],
                        ],
                    ],
                ],
                [
                    'label' => LanguageDropdown::label(Yii::$app->language),
                    'items' => LanguageDropdown::widget(),
                ],
            ];
            $menuItems[] = '<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>';
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-right ml-auto'],
            'items'   => $menuItems,
        ]);
        ?>

        <?php NavBar::end(); ?>

        <div class="container">
            <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>