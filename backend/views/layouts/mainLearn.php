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
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;
use common\models\UserModel;
use common\models\MainCategory;

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

$category = MainCategory::find()->andWhere(['company_id' => Yii::$app->user->id])->one();

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html <?= yii::$app->language == 'ar' ? 'dir="rtl" ' . "lang=" . yii::$app->language : "lang=" . yii::$app->language ?>>
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
                          'brandLabel' => 'Learning',
                          'brandUrl'   => Yii::$app->homeUrl,
                          'options'    => ['class' => 'sticky-top navbar-expand-lg navbar-dark bg-dark ml-auto',],
                      ]);
        $menuItems = [
            [
                'label' => Yii::t('app', 'Home'),
                'url'   => ['/site/index'],
            ],
            [
                'label' => LanguageDropdown::label(Yii::$app->language),
                'items' => LanguageDropdown::widget(),
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
            $teams     = [];
            $menuItems = [];
            if ($category instanceof MainCategory)
            {
                $teams = MainCategory::getMainCategoryList();
            }
            $menuItems   = [
                [
                    'label'   => Yii::t('app', 'Learn Material'),
                    'items'   => [
                        [
                            'label' => Yii::t('app', 'Staff'),
                            'url'   => ['/learn/learn-staff'],
                        ],
                        [
                            'label' => Yii::t('app', 'Material'),
                            'url'   => ['/learn/learn-material'],
                        ],
                    ],
                    //'visible' => Yii::$app->user->can('learn-material.index'),
                ],
                [
                    'label' => LanguageDropdown::label(Yii::$app->language),
                    'items' => LanguageDropdown::widget(),
                ],
            ];
            $menuItems[] = '<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>';
        }

        echo Nav::widget([
                             'options' => ['class' => Yii::$app->language == 'ar' ? 'navbar-right ml-auto pull-left' : 'navbar-right ml-auto'],
                             'items'   => $menuItems,
                         ]);
        ?>
        <div class="navSearch">
            <?php
            $form = ActiveForm::begin([
                                          'id'     => 'navSearchForm',
                                          'method' => 'GET',
                                          'action' => Url::toRoute('/search/global-search'),
                                      ]);
            ?>

            <?php
            echo Html::textInput('search', (Yii::$app->controller->id == 'search' && Yii::$app->controller->action->id == 'global-search') ? Yii::$app->request->get('search') : null, [
                'autocomplete' => 'off',
                'class'        => 'navSearchTextBox pull-right',
                'id'           => 'navSearchString',
                'placeholder'  => Yii::t('app', 'Search to') . '...',
                'value'        => 'test',
            ]);
            echo Html::submitButton(Icon::show('search'), ['class' => 'btn btn-secondary navSearchSubmit'])
            ?>
            <?php ActiveForm::end(); ?>
        </div>
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