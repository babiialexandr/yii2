<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'IudhfSdhfbj663djSSa',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                '<module:w+>' => '<module>',
                '<module:w+>/<controller:w+>' => '<module>/<controller>',
                '<module:w+>/<controller:w+>/<action:w+>' => '<module>/<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableFlashMessages' => false,
            'adminPermission' => 'admin',
            'confirmWithin' => 21600,
            'admins' => ['admin'],
            'controllerMap' => [
                'admin' => [
                    'class' => 'dektrium\user\controllers\AdminController',
                    'as access' => [
                        'class' => 'yii\filters\AccessControl',
                        'rules' => [
                            [
                                'allow' => true,
                                'roles' => ['admin'],
                            ]
                        ],
                    ],
                ],
                'security' => [
                    'class' => 'dektrium\user\controllers\SecurityController',
                ],
                'registration' => [
                    'class' => 'dektrium\user\controllers\RegistrationController',
                    'on ' . dektrium\user\controllers\RegistrationController::EVENT_AFTER_CONFIRM => function () {
                        Yii::$app->response->redirect(['/user/security/login'])->send();
                        Yii::$app->end();
                    },
                ],
                'recovery' => [
                    'class' => 'dektrium\user\controllers\RecoveryController',
                ],
                'profile' => [
                    'class' => 'app\controllers\ProfileController',
                ],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
