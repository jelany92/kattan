<?php

use kartik\mpdf\Pdf;

$params = array_merge(require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php');

return [
    'id'                  => 'app-backend',
    'name'                => 'JOBquick-Admin',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log'],
    'modules'             => [],
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-backend',
        ],
        'user'         => [
            'identityClass'   => 'common\models\UserModel',
            'class'           => 'backend\components\WebUser',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name'     => '_identity-backend',
                'httpOnly' => true,
            ],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log'          => [
            'flushInterVal' => 1,
            'traceLevel'    => YII_DEBUG ? 3 : 0,
            'targets'       => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning',
                    ],
                    'exportInterval' => 1,
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
                'en',
                'de',
                'ar',
            ],
        ],

        'pdf'  => [
            'class'       => Pdf::class,
            'format'      => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
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
