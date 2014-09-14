<?php

// The production path is /kims/web, anything else is a dev env
$env = preg_match('`\/kims\/web$`', __DIR__) ? 'prod' : 'dev';

defined('YII_DEBUG') or define('YII_DEBUG', 'prod' === $env ? false : true);
defined('YII_ENV') or define('YII_ENV', $env);

require(__DIR__ . '/../globals.php');
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
