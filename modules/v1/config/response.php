<?php
/**
 * 自定义错误响应
 * 有时你可能想自定义默认的错误响应格式。
 * 例如，你想一直使用HTTP状态码200，
 * 而不是依赖于使用不同的HTTP状态来表示不同的错误，
 * 并附上实际的HTTP状态代码为JSON结构的一部分的响应
 */
return [
    'class' => 'yii\web\Response',
    'on beforeSend' => function ($event) {
        $response = $event->sender;
        $response->statusCode = 200;
    }
];
