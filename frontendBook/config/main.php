<?php
$params = array_merge(require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php');

return [
    'id'                  => 'app-frontendBook',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'frontendBook\controllers',
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-frontendBook',
        ],
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name'     => '_identity-frontendBook',
                'httpOnly' => true,
            ],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the frontendBook
            'name' => 'advanced-frontendBook',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => true,
            'rules'           => [],
            'class'           => 'codemix\localeurls\UrlManager',
            'languages'       => [
                'en' => 'English',
                'de' => 'Deutsh',
                'ar' => 'العربية',
            ],
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class'   => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
    ],
    'params'              => $params,
];
