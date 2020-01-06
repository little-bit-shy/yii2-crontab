<?php

if (YII_ENV_PROD) {
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
} else if (YII_ENV_TEST) {
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
} else if (YII_ENV_DEV) {
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
}
