<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    // 设置目标语言为中文
    'language' => 'zh-CN',
    // 设置源语言为英语
    'sourceLanguage' => 'en-US',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '0_0w-naFBuT9NGxrkABFtAszJiouNl8s',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logVars' => [],
                    'levels' => ['info', 'error', 'warning'],
                    'categories' => [
                        'application',
                    ],
                    'prefix' => function ($message) {
                        // 获取userid
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $userId = $user ? $user->getId(false) : '-';
                        // 获取客户端ip
                        $serverIp = Yii::$app->getRequest()->getUserIP();
                        $serverIp = $serverIp ?: '-';
                        // 获取会话信息
                        $sessionId = (new \yii\web\Session())->getId();
                        $sessionId = $sessionId ?: '-';
                        // 获取路由
                        $pathInfo = Yii::$app->getRequest()->getPathInfo();
                        $pathInfo = $pathInfo ?: '-';
                        // 获取请求头参数
                        $queryParams = Yii::$app->getRequest()->getQueryString();
                        $queryParams = $queryParams ?: '-';
                        // 获取请求体参数
                        $bodyParams = Yii::$app->getRequest()->getBodyParams();
                        $bodyParams = $bodyParams ? \yii\helpers\Json::encode($bodyParams) : '-';
                        return "[$userId][$serverIp][$sessionId][$pathInfo][$queryParams][$bodyParams]";
                    }
                ],
            ],
        ],
        'db' => $db,
        //路由配置
        'urlManager' => require(__DIR__ . '/urlManager.php'),
    ],
    //模块相关配置
    'modules' => require(__DIR__ . '/modules.php'),
    //别名定义
    'aliases' => require(__DIR__ . '/aliases.php'),
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
