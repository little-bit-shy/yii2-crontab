<?php

if (YII_ENV_PROD) {
    return [
        'class' => "\app\components\Kafka",
        'broker_list' => '192.168.253.133:9092,192.168.253.131:9092,192.168.253.132:9092',
    ];
} else if (YII_ENV_TEST) {
    return [
        'class' => "\app\components\Kafka",
        'broker_list' => '192.168.253.133:9092,192.168.253.131:9092,192.168.253.132:9092',
    ];
} else if (YII_ENV_DEV) {
    return [
        'class' => "\app\components\Kafka",
        'broker_list' => '192.168.253.133:9092,192.168.253.131:9092,192.168.253.132:9092',
    ];
}
