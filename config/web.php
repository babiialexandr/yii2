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
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views/admin' => '@app/views/user/admin'
                ],
            ],
        ],
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp',
                'port' => 1025,
            ],
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
                '/' => 'message/index',
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
            'enableConfirmation' => false,
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
                    'on ' . \dektrium\user\controllers\AdminController::EVENT_AFTER_UPDATE => [
                        \app\listeners\UserListener::class,
                        'adminAssignRole'
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
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_REGISTER => [
                        \app\listeners\UserListener::class,
                        'registerAssignRole'
                    ],
                ],
                'recovery' => [
                    'class' => 'dektrium\user\controllers\RecoveryController',
                ],
                'profile' => [
                    'class' => 'app\controllers\ProfileController',
                ],
            ],
            'modelMap' => [
                'User' => 'app\models\User',
            ]
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
        'allowedIPs' => ['*'],
    ];
}

return $config;
