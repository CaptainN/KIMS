<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
   'modules' => [
      'auth' => [
         'class' => 'auth\Module',
         'layout' => '//main', // Layout when not logged in yet
         'layoutLogged' => '//main', // Layout for logged in users
         'attemptsBeforeCaptcha' => 3, // Optional
         'superAdmins' => ['admin'], // SuperAdmin users
         'tableMap' => [ // Optional, but if defined, all must be declared
            'User' => 'user',
            'UserStatus' => 'user_status',
            'ProfileFieldValue' => 'profile_field_value',
            'ProfileField' => 'profile_field',
            'ProfileFieldType' => 'profile_field_type',
         ],
      ],
   ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
      'authManager' => [
         'class' => 'yii\rbac\DbManager',
      ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
