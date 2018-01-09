<?php

return [
    'class' => 'yii\web\Request',
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => 'W8aLzUU1VE-PKDr2ozLyyV1wV--DGkbe',
    'parsers' => [
        'application/json' => 'yii\web\JsonParser',
    ]
];
