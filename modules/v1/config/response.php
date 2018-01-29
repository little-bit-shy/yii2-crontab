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

        // 处理code、message
        if (
            isset($data['type']) // 存在type
            && class_exists($data['type']) // type是个类
            && is_subclass_of($data['type'], '\yii\base\Exception') // type 继承自\yii\base\Exception
        ) {
            $code = $data['code'];
            $message = $data['message'];
            if (strpos($message, '|')) {
                list($message, $code) = explode('|', $message);
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
        // 放在后面，避免污染IsSuccessfulz
        $response->setStatusCode(200);
    }
];