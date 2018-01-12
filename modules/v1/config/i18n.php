<?php

return [
    'class' => yii\i18n\I18N::className(),
    'translations' => [
        'app*' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@v1/config/messages',
            /*'fileMap' => [
                'app/error' => 'error.php',
            ],*/
        ],
    ],
];
