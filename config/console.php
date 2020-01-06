<?php

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    // 设置目标语言为中文
    'language' => 'zh-CN',
    // 设置源语言为英语
    'sourceLanguage' => 'en-US',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::className(),
                    'logFile' => '@runtime/logs/console.log',
                    'maxFileSize' => 102400,
                    'maxLogFiles' => 20,
                    'logVars' => [],
                    'levels' => ['info', 'error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        // kafka配置
        'kafka' => require(__DIR__ . '/kafka.php')
    ],
    // 别名定义
    'aliases' => require(__DIR__ . '/aliases.php'),
    'params' => require __DIR__ . '/params.php',
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
