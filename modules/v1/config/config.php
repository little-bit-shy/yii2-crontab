<?php

$authClientCollection = require(__DIR__ . '/authClientCollection.php');
$db = require(__DIR__ . '/db.php');
$redis = require(__DIR__ . '/redis.php');
$user = require(__DIR__ . '/user.php');
$request = require(__DIR__ . '/request.php');
$response = require(__DIR__ . '/response.php');
$cache = require(__DIR__ . '/cache.php');
$i18n = require(__DIR__ . '/i18n.php');
$authManager = require(__DIR__. '/authManager.php');
$params = require(__DIR__ . '/params.php');

$config = [
    'components' => [
        //Oauth 2 相关配置
        'authClientCollection' => $authClientCollection,
        //数据库配置
        'db' => $db,
        //Redis配置
        'redis' => $redis,
        //用户验证相关配置
        'user' => $user,
        //请求相关配置
        'request' => $request,
        //响应相关配置
        'response' => $response,
        //缓存相关配置
        'cache' => $cache,
        //国际化处理
        'i18n' => $i18n,
        //rbac权限管理
        'authManager' => $authManager,
    ],
    'params' => $params,
];

return $config;
