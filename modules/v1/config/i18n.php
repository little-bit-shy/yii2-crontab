<?php

return [
    'class' => yii\i18n\I18N::className(),
    'translations' => [
        'app*' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@app/config/messages',
            /*'fileMap' => [
                'app/error' => 'error.php',
            ],*/
        ],
    ],
];
