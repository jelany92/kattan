<?php

// common/config/main.php

return [
    'id'         => 'common-main',
    'language'   => 'de',
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules'    => [
        'auth'     => [
            'class' => 'common\models\auth\Module',
        ],
        'gridview' => [
            'class'          => '\kartik\grid\Module',
            //'downloadAction' => 'export',
            'downloadAction' => 'gridview/export/download',
        ],
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',

            // the global settings for the facebook widget
            'facebook' => [
                'appId' => '228100621678999',
            ],
        ],
    ],
    'components' => [
        'cache'       => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        /*'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '940357736174857',
                    'clientSecret' => 'c3f698c9698e97fed428cc349b7c3bd2',
                ],
                // etc.
            ],
        ],*/
        'i18n'        => [
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
        /*   'queue' => [
               'class' => \yii\queue\db\Queue::class,
               'db' => 'db', // DB connection component or its config
               'tableName' => '{{%queue}}', // Table name
               'channel' => 'default', // Queue channel key
               'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
               'as queueBehavior' => \common\models\queue\QueueBehavior::class,
           ],*/
        'log'         => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning',
                    ],
                ],
                [
                    'class'   => 'yii\log\EmailTarget',
                    'enabled' => YII_ENV_PROD,
                    'levels'  => ['error'],
                    'except'  => ['yii\web\HttpException:404'],
                    'message' => [
                        'from'    => ['error@adamstor'],
                        'to'      => [
                            'j_robben92@hotmail.com',
                        ],
                        'subject' => 'Fehler aufgetreten im Admin-Modul Backend',
                    ],
                ],
            ],
        ],
    ],
];
