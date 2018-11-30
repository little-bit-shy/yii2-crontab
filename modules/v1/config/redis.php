<?php
/**
 * redis相关配置
 * 不建议redis版本低于 2.6.12
 */

if (YII_DEBUG) {
    return [
        'class' => \yii\redis\Connection::className(),
        'hostname' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
    ];
} else {
    return [
        'class' => \yii\redis\Connection::className(),
        'hostname' => '127.0.0.1',
        'port' => 6378,
        'database' => 0,
    ];
}
