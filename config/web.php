<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
   'id' => 'kims',
   'basePath' => dirname(__DIR__),
   'bootstrap' => ['log'],
   'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
   'modules' => [
      'auth' => [
         'class' => '\auth\Module',
         'layout' => '//main', // Layout when not logged in yet
         'layoutLogged' => '//main', // Layout for logged in users
         'attemptsBeforeCaptcha' => 3, // Optional
         'superAdmins' => ['admin', 'levitzm'], // SuperAdmin users
         'tableMap' => [ // Optional, but if defined, all must be declared
            'User' => 'user',
            'UserStatus' => 'user_status',
            'ProfileFieldValue' => 'profile_field_value',
            'ProfileField' => 'profile_field',
            'ProfileFieldType' => 'profile_field_type',
         ],
      ],
      'gridview' => [
         'class' => '\kartik\grid\Module',
      ],
      'datecontrol' => [
         'class' => '\kartik\datecontrol\Module',
         
         // don't automatically display the picker widget
         'autoWidget' => false,
         
         // format settings for displaying each date attribute
         'displaySettings' => [
            \kartik\datecontrol\Module::FORMAT_DATE => 'm/d/Y',
            \kartik\datecontrol\Module::FORMAT_TIME => 'H:i:s A',
            \kartik\datecontrol\Module::FORMAT_DATETIME => 'm/d/Y H:i:s A',
         ],

         // format settings for saving each date attribute
         'saveSettings' => [
            \kartik\datecontrol\Module::FORMAT_DATE => 'Y-m-d',
            \kartik\datecontrol\Module::FORMAT_TIME => 'H:i:s',
            \kartik\datecontrol\Module::FORMAT_DATETIME => 'Y-m-d H:i:s',
         ]
      ],
   ],
   'components' => [
      /*'urlManager' => [
         'enablePrettyUrl' => true,
         'enableStrictParsing' => true,
         'showScriptName' => false,
         'rules' => [
            '' => 'site/index',
            '<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>' =>
             '<module>/<controller>/<action>',
            '<controller:[\w-]+>' => '<controller>/index',
            '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
            '<controller:[\w-]+>/<id:\d+>/<title>' => '<controller>/view',
            '<controller:[\w-]+>/<id:\d+>' => '<controller>/view',
         ],
      ],*/
      'authManager' => [
         'class' => '\yii\rbac\DbManager',
         'defaultRoles' => ['guest'],
      ],
      'cache' => [
         'class' => '\yii\caching\FileCache',
      ],
      'user' => [
         'class' => '\app\components\User',
         'identityClass' => '\app\models\User',
         'enableAutoLogin' => false,
      ],
      'errorHandler' => [
         'errorAction' => 'site/error',
      ],
      'mail' => [
         'class' => '\yii\swiftmailer\Mailer',
         'useFileTransport' => true,
      ],
      'log' => [
         'traceLevel' => YII_DEBUG ? 3 : 0,
         'targets' => [
            [
               'class' => '\yii\log\FileTarget',
               'levels' => ['error', 'warning'],
            ],
         ],
      ],
      'session' => [
         'class' => '\yii\web\DbSession',
      ],
      /*'response' => [
         'formatters' => [
            'pdf' => [
               'class' => 'robregonm\pdf\PdfResponseFormatter',
            ],
         ],
      ],*/
      'db' => $db,
   ],
   'params' => $params,
];

if (YII_ENV_DEV)
{
   // configuration adjustments for 'dev' environment
   $config['bootstrap'][] = 'debug';
   $config['modules']['debug'] = [
      'class' => '\yii\debug\Module',
      'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*', '24.168.37.5'],
   ];
   $config['modules']['gii'] = [
      'class' => '\yii\gii\Module',
      'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*', '24.168.37.5'],
   ];
}

return $config;
