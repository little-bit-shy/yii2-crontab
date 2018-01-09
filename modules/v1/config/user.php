<?php

return [
    'class' => 'yii\web\User',
    'identityClass' => 'app\models\User',
    'enableSession' => false,//请求中的用户认证状态就不能通过session来保持
    'loginUrl' => null,//属性为null 显示一个HTTP 403 错误而不是跳转到登录界面.
];
