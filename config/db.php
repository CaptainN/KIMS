<?php

if ('prod' === YII_ENV)
{
	return [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host=tokims.db.3180200.hostedresource.com;dbname=tokims',
	    'username' => 'tokims',
	    'password' => 'HFUpsavntE2N@9',
	    'charset' => 'utf8',
	];
} else {
	return [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host=kimsdev.db.3180200.hostedresource.com;dbname=kimsdev',
	    'username' => 'kimsdev',
	    'password' => 'l@HVHatP!6LDHzm',
	    'charset' => 'utf8',
	];
}