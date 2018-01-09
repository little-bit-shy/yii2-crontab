<?php

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
