<?php
/**
 * 邮件相关配置
 */

if (YII_ENV_PROD) {
    return [
        'class' => 'yii\swiftmailer\Mailer',
        'viewPath' => '@app/mail',
        'useFileTransport' => false,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.qq.com',
            'username' => '发送者邮箱地址',//发送者邮箱地址
            'password' => 'SMTP密码', //SMTP密码
            'port' => '25',
            'encryption' => 'tls',
        ],
    ];
} else if (YII_ENV_TEST) {
    return [
        'class' => 'yii\swiftmailer\Mailer',
        'viewPath' => '@app/mail',
        'useFileTransport' => false,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.qq.com',
            'username' => '发送者邮箱地址',//发送者邮箱地址
            'password' => 'SMTP密码', //SMTP密码
            'port' => '25',
            'encryption' => 'tls',
        ],
    ];
} else if (YII_ENV_DEV) {
    return [
        'class' => 'yii\swiftmailer\Mailer',
        'viewPath' => '@app/mail',
        'useFileTransport' => false,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.qq.com',
            'username' => '发送者邮箱地址',//发送者邮箱地址
            'password' => 'SMTP密码', //SMTP密码
            'port' => '25',
            'encryption' => 'tls',
        ],
    ];
}
