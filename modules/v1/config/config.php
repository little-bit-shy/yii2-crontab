<?php

$config = [
    'components' => [
        //Oauth 2 相关配置
        'authClientCollection' => require(__DIR__ . '/authClientCollection.php'),
        //数据库配置
        'db' => require(__DIR__ . '/db.php'),
        //Redis配置
        'redis' => require(__DIR__ . '/redis.php'),
        //用户验证相关配置
        'user' => require(__DIR__ . '/user.php'),
        //请求相关配置
        'request' => require(__DIR__ . '/request.php'),
        //响应相关配置
        'response' => require(__DIR__ . '/response.php'),
    ],
    'params' => require(__DIR__ . '/params.php'),
];

return $config;
