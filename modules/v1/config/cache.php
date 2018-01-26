<?php

return [
    'class' => \yii\redis\Cache::className(),
    'redis' => [
        'hostname' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
    ]
];
