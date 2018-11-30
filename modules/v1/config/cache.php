<?php

if (YII_DEBUG) {
    return [
        'class' => \yii\redis\Cache::className(),
        'redis' => [
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
        'keyPrefix' => 'app_',
    ];
} else {
    return [
        'class' => \yii\redis\Cache::className(),
        'redis' => [
            'hostname' => '127.0.0.1',
            'port' => 6378,
            'database' => 0,
        ],
        'keyPrefix' => 'app_',
    ];
}