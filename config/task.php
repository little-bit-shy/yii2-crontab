<?php

if (YII_ENV_PROD) {
    return [
        // 服务端
        'server_host' => '127.0.0.1',
        // 客户端
        'client_host' => '127.0.0.1',
        // 通讯端口
        'port' => '9501',
        // 通讯秘钥
        'sign' => '1gf281f01gf0120gf2101',
        // 连接超时时间
        'timeout' => 1,
        // Redis任务队列
        'key' => 'swoole_task_list',
    ];
} else if (YII_ENV_TEST) {
    return [
        // 服务端
        'server_host' => '127.0.0.1',
        // 客户端
        'client_host' => '127.0.0.1',
        // 通讯端口
        'port' => '9501',
        // 通讯秘钥
        'sign' => '1gf281f01gf0120gf2101',
        // 连接超时时间
        'timeout' => 1,
        // Redis任务队列
        'key' => 'swoole_task_list',
    ];
} else if (YII_ENV_DEV) {
    return [
        // 服务端
        'server_host' => '127.0.0.1',
        // 客户端
        'client_host' => '127.0.0.1',
        // 通讯端口
        'port' => '9501',
        // 通讯秘钥
        'sign' => '1gf281f01gf0120gf2101',
        // 连接超时时间
        'timeout' => 1,
        // Redis任务队列
        'key' => 'swoole_task_list',
    ];
}

