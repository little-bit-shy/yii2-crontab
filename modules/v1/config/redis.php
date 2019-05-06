<?php
/**
 * redis相关配置
 * 不建议redis版本低于 2.6.12
 */

if (YII_ENV_PROD) {
    return [
        'class' => \yii\redis\Connection::className(),
        'hostname' => '127.0.0.1',
        'port' => 6378,
        'database' => 0,
    ];
} else if (YII_ENV_TEST) {
    return [
        'class' => \yii\redis\Connection::className(),
        'hostname' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
    ];
} else if (YII_ENV_DEV) {
    return [
        'class' => \yii\redis\Connection::className(),
        'hostname' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
    ];
}
