<?php

// common/config/main.php

return [
    'id' => 'common-main',
    'language' => 'de',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
     /*   'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
            'as queueBehavior' => \common\models\queue\QueueBehavior::class,
        ],*/
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning' ],
                ],
                [
                    'class'   => 'yii\log\EmailTarget',
                    'enabled' => YII_ENV_PROD,
                    'levels'  => ['error'],
                    'except'  => ['yii\web\HttpException:404'],
                    'message' => [
                        'from'    => ['error@admin.jobquick.net'],
                        'to'      => [
                            'max.kirmair@aicovo.com',
                            'jelani.qattan@aicovo.com',
                            'nico.nuernberger@aicovo.com',
                            'benedikt.rosenmueller@aicovo.com'
                        ],
                        'subject' => 'Fehler aufgetreten im Admin-Modul Backend',
                    ],
                ],
            ],
        ],
    ],
];
