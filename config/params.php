<?php

$task = require(__DIR__ . '/task.php');
$mailer = require(__DIR__ . '/mailer.php');
unset($mailer['class']);

return [
    'adminEmail' => $mailer['transport']['username'],
    // 只用于Cli模式，避免Yii单例实例化出现链接超时情况
    'mailer' => $mailer,
    'task' => $task
];

