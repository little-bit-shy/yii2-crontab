<?php

if (YII_ENV_PROD) {
    return [
        'class' => \yii\db\Connection::className(),
        'dsn' => 'mysql:host=127.0.0.1;dbname=yii2restful',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
        'tablePrefix' => 'yii2_'
    ];
} else if (YII_ENV_TEST) {
    return [
        'class' => \yii\db\Connection::className(),
        'dsn' => 'mysql:host=127.0.0.1;dbname=yii2restful',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
        'tablePrefix' => 'yii2_'
    ];
} else if (YII_ENV_DEV) {
    return [
        'class' => \yii\db\Connection::className(),
        'dsn' => 'mysql:host=127.0.0.1;dbname=yii2restful',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
        'tablePrefix' => 'yii2_'
    ];
}
