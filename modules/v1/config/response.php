<?php
/**
 * 自定义错误响应
 * 有时你可能想自定义默认的错误响应格式。
 * 例如，你想一直使用HTTP状态码200，
 * 而不是依赖于使用不同的HTTP状态来表示不同的错误，
 * 并附上实际的HTTP状态代码为JSON结构的一部分的响应
 */
return [
    'class' => \yii\web\Response::className(),
    'on beforeSend' => function ($event) {
        /** @var \yii\web\Response $response */
        $response = $event->sender;
        $data = $response->data;

        if (is_string($data)) {
            // 如果是字符串不则做处理
            return;
        }

        // 异常数据处理
        if ($response->getIsSuccessful() == false) {
            list($message, $code) = explode('|', $data['message']);

            // 避免污染异常处理器的传参
            if ($data['code'] != 0) {
                $code = $data['code'];
            }

            $response->data = array_merge($response->data, [
                'code' => (int)$code,
                'message' => $message
            ]);
        }

        // 数据格式重构
        $response->data = [
            'success' => $response->getIsSuccessful(),
            'data' => $response->data,
        ];
        // 放在后面，避免污染IsSuccessful
        $response->statusCode = 200;
    }
];
