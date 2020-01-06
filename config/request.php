<?php

if (YII_ENV_PROD) {
    return [
        'class' => 'yii\web\Request',
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'W8aLzUU1VE-PKDr2ozLyyV1wV--DGkbe',
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
        ]
    ];
} else if (YII_ENV_TEST) {
    return [
        'class' => 'yii\web\Request',
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'W8aLzUU1VE-PKDr2ozLyyV1wV--DGkbe',
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
        ]
    ];
} else if (YII_ENV_DEV) {
    return [
        'class' => 'yii\web\Request',
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'W8aLzUU1VE-PKDr2ozLyyV1wV--DGkbe',
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
        ]
    ];
}
