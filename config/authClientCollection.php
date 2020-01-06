<?php

if (YII_ENV_PROD) {
    return [
        'class' => 'yii\authclient\Collection',
        'clients' => [
            'github' => [
                'class' => 'yii\authclient\clients\GitHub',
                'clientId' => '*****************',
                'clientSecret' => '********************',
            ],
            'qq' => [
                'class'=>'yii\authclient\clients\QqOAuth',
                'clientId'=>'*********',
                'clientSecret'=>'***************',
            ],
            // etc.
        ],
    ];
} else if (YII_ENV_TEST) {
    return [
        'class' => 'yii\authclient\Collection',
        'clients' => [
            'github' => [
                'class' => 'yii\authclient\clients\GitHub',
                'clientId' => '*****************',
                'clientSecret' => '********************',
            ],
            'qq' => [
                'class'=>'yii\authclient\clients\QqOAuth',
                'clientId'=>'*********',
                'clientSecret'=>'***************',
            ],
            // etc.
        ],
    ];
} else if (YII_ENV_DEV) {
    return [
        'class' => 'yii\authclient\Collection',
        'clients' => [
            'github' => [
                'class' => 'yii\authclient\clients\GitHub',
                'clientId' => '*****************',
                'clientSecret' => '********************',
            ],
            'qq' => [
                'class'=>'yii\authclient\clients\QqOAuth',
                'clientId'=>'*********',
                'clientSecret'=>'***************',
            ],
            // etc.
        ],
    ];
}